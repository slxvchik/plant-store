<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Domain\Product\Model\Offer as DomainOffer;
use App\Domain\Product\Model\Product as DomainProduct;
use App\Domain\Product\Model\Stock;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Shared\SortedItem\SortedItem;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Override;
use Throwable;

class ProductRepositoryImpl implements ProductRepository
{
    #[Override]
    public function create(DomainProduct $product): string
    {
        DB::transaction(function () use ($product) {
            Product::create($this->productAttributes($product));
            $this->syncOffers($product);
            $this->syncProductRelations($product);
        });

        return $product->id->value;
    }

    #[Override]
    public function update(DomainProduct $product): void
    {
        DB::transaction(function () use ($product) {
            $model = Product::findOrFail($product->id->value);
            $model->update($this->productAttributes($product));
            $this->syncOffers($product);
            $this->syncProductRelations($product);
        });
    }

    #[Override]
    public function delete(string $id): void
    {
        Product::findOrFail($id)->delete();
    }

    #[Override]
    public function findById(string $id): ?DomainProduct
    {
        return $this->query()->find($id)?->toDomain();
    }

    #[Override]
    public function findByIds(array $ids): array
    {
        return $this->query()
            ->whereIn('id', $ids)
            ->orderBy('sort')
            ->get()
            ->map(fn (Product $product): DomainProduct => $product->toDomain())
            ->all();
    }

    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        $paginator = $this->query()
            ->orderBy('sort')
            ->paginate(perPage: $pageable->perPage, page: $pageable->page);

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (Product $product): DomainProduct => $product->toDomain(),
        );
    }

    #[Override]
    public function findByAlias(string $alias): ?DomainProduct
    {
        return $this->query()->firstWhere('alias', $alias)?->toDomain();
    }

    /**
     * @throws InvalidArgumentException
     */
    #[Override]
    public function search(ProductSearchCriteria $criteria, Pageable $pageable): Page
    {
        $query = $this->query()->orderBy('sort');

        if ($criteria->active !== null) {
            $query->where('products.active', $criteria->active);
        }

        if ($criteria->name !== null) {
            $query->where('products.name', 'like', "%{$criteria->name}%");
        }

        if ($criteria->categoryId !== null) {
            $query->whereIn('products.id', function ($subQuery) use ($criteria): void {
                $subQuery->select('product_id')
                    ->from('product_categories')
                    ->where('category_id', $criteria->categoryId);
            });
        }

        if ($criteria->tagIds !== []) {
            $query->whereIn('products.id', function ($subQuery) use ($criteria): void {
                $subQuery->select('product_id')
                    ->from('product_tags')
                    ->whereIn('tag_id', $criteria->tagIds);
            });
        }

        if ($this->hasOfferCriteria($criteria)) {
            $query->whereIn('products.id', function ($subQuery) use ($criteria): void {
                $subQuery->select('product_offers.product_id')
                    ->from('offers')
                    ->join('product_offers', 'product_offers.offer_id', '=', 'offers.id');

                $this->applyOfferCriteria($subQuery, $criteria);
            });
        }

        $paginator = $query->paginate(perPage: $pageable->perPage, page: $pageable->page);

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (Product $product): DomainProduct => $product->toDomain(),
        );
    }

    /**
     * @return Builder<Product>
     */
    private function query(): Builder
    {
        return Product::query()->with('offers');
    }

    /**
     * @return array<string, mixed>
     */
    private function productAttributes(DomainProduct $product): array
    {
        return [
            'id' => $product->id->value,
            'active' => $product->active,
            'alias' => $product->alias,
            'sort' => $product->sort,
            'name' => $product->name,
            'description' => $product->description,
        ];
    }

    private function offerAttributes(DomainOffer $offer): array
    {
        return [
            'id' => $offer->id->value,
            'active' => $offer->active,
            'sku' => $offer->sku,
            'sort' => $offer->sort,
            'description' => $offer->description,
            'price' => $offer->price,
            'form_factor' => $offer->formFactor,
            'size' => $offer->size,
            'age_in_months' => $offer->age,
            'sowing_date' => $offer->sowingDate,
        ];
    }

    private function syncOffers(DomainProduct $product): void
    {
        $productId = $product->id->value;
        $offers = $product->getOffers();

        $newOfferIds = array_map(fn (DomainOffer $o) => $o->id->value, $offers);

        $offersToDelete = DB::table('product_offers')
            ->where('product_id', $productId)
            ->whereNotIn('offer_id', $newOfferIds)
            ->pluck('offer_id')
            ->toArray();

        if (! empty($offersToDelete)) {
            DB::table('offers')->whereIn('id', $offersToDelete)->delete();
        }

        if (empty($offers)) {
            return;
        }

        $offersData = array_map(fn (DomainOffer $o) => $this->offerAttributes($o), $offers);

        Offer::upsert($offersData, ['id'], [
            'id',
            'active',
            'sku',
            'sort',
            'description',
            'price',
            'form_factor',
            'size',
            'age_in_months',
            'sowing_date',
            'updated_at',
        ]);

        $offerPivotData = [];
        foreach ($offers as $offer) {
            $offerId = $offer->id->value;

            $offerPivotData[] = ['product_id' => $productId, 'offer_id' => $offerId];

            $this->syncRelationships('offer_stocks', 'offer_id', $offerId, $offer->stocks, function (Stock $stock) {
                return [
                    'warehouse_id' => $stock->warehouseId,
                    'quantity' => $stock->quantity,
                    'reserved' => $stock->reserved,
                ];
            });
            $this->syncRelationships('offer_images', 'offer_id', $offerId, $offer->imageIds, function (SortedItem $sortedImage) {
                return [
                    'image_id' => $sortedImage->id,
                    'sort' => $sortedImage->sort,
                ];
            });
            $this->syncRelationships('offer_videos', 'offer_id', $offerId, $offer->videoIds, function (SortedItem $sortedVideo) {
                return [
                    'video_id' => $sortedVideo->id,
                    'sort' => $sortedVideo->sort,
                ];
            });
        }

        DB::table('product_offers')->where('product_id', $productId)->delete();
        DB::table('product_offers')->insert($offerPivotData);
    }

    /**
     * @throws Throwable
     */
    private function syncProductRelations(DomainProduct $product): void
    {
        $productId = $product->id->value;

        $this->syncRelationships('product_categories', 'product_id', $productId, $product->categoryIds, function (string $categoryId) {
            return [
                'category_id' => $categoryId,
            ];
        });
        $this->syncRelationships('product_tags', 'product_id', $productId, $product->tagIds, function (string $tagId) {
            return [
                'tag_id' => $tagId,
            ];
        });
        $this->syncRelationships('product_offers', 'product_id', $productId, $product->getOffers(), function (DomainOffer $offer) {
            return [
                'offer_id' => $offer->id->value,
            ];
        });
        $this->syncRelationships('product_images', 'product_id', $productId, $product->imageIds, function (SortedItem $sortedImage) {
            return [
                'image_id' => $sortedImage->id,
                'sort' => $sortedImage->sort,
            ];
        });
        $this->syncRelationships('product_videos', 'product_id', $productId, $product->videoIds, function (SortedItem $sortedVideo) {
            return [
                'video_id' => $sortedVideo->id,
                'sort' => $sortedVideo->sort,
            ];
        });
    }

    /**
     * @throws Throwable
     */
    private function syncRelationships(
        string $table,
        string $entityIdColumn,
        string $entityId,
        array $items,
        callable $mapCallback,
    ): void {
        DB::table($table)->where($entityIdColumn, $entityId)->delete();

        if (empty($items)) {
            return;
        }

        $insertData = [];
        foreach ($items as $item) {
            $insertData[] = array_merge(
                [$entityIdColumn => $entityId],
                $mapCallback($item)
            );
        }

        if (! empty($insertData)) {
            DB::table($table)->insert($insertData);
        }
    }

    private function hasOfferCriteria(ProductSearchCriteria $criteria): bool
    {
        return $criteria->sku !== null
            || $criteria->formFactor !== null
            || $criteria->size !== null
            || $criteria->age !== null
            || $criteria->minPrice !== null
            || $criteria->maxPrice !== null
            || $criteria->sowingDateFrom !== null
            || $criteria->sowingDateTo !== null;
    }

    private function applyOfferCriteria(QueryBuilder $query, ProductSearchCriteria $criteria): void
    {
        if ($criteria->sku !== null) {
            $query->where('offers.sku', $criteria->sku);
        }

        if ($criteria->formFactor !== null) {
            $query->where('offers.form_factor', $criteria->formFactor);
        }

        if ($criteria->size !== null) {
            $query->where('offers.size', $criteria->size);
        }

        if ($criteria->age !== null) {
            $query->where('offers.age_in_months', $criteria->age);
        }

        if ($criteria->minPrice !== null) {
            $query->where('offers.price', '>=', $criteria->minPrice);
        }

        if ($criteria->maxPrice !== null) {
            $query->where('offers.price', '<=', $criteria->maxPrice);
        }

        if ($criteria->sowingDateFrom !== null) {
            $query->whereDate('offers.sowing_date', '>=', $criteria->sowingDateFrom->format('Y-m-d'));
        }

        if ($criteria->sowingDateTo !== null) {
            $query->whereDate('offers.sowing_date', '<=', $criteria->sowingDateTo->format('Y-m-d'));
        }
    }
}
