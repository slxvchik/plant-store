<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Domain\Product\Criteria\ProductSort;
use App\Domain\Product\Model\OfferModel as DomainOffer;
use App\Domain\Product\Model\ProductModel as DomainProduct;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Shared\SortedItem\SortedItem;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
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
    public function findAll(): array
    {
        return $this->query()->orderBy('sort')->get()
            ->map(fn (Product $product): DomainProduct => $product->toDomain())->all();
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
        $query = $this->getSearchSortQuery($criteria->sort);

        if ($criteria->active === true) {
            $query->where(function ($q) {
                $q->whereNull('products.category_id')
                    ->orWhereNotIn('products.category_id', function ($sub) {
                        $sub->select('id')
                            ->from('categories')
                            ->where('active', false);
                    });
            });
        }

        if ($criteria->name !== null) {
            $query->where('products.name', 'like', "%{$criteria->name}%");
        }

        if ($criteria->categoryAliases !== []) {
            $query->whereIn('products.category_id', function ($q) use ($criteria) {
                $q->select('id')
                    ->from('categories')
                    ->whereIn('alias', $criteria->categoryAliases);
                if ($criteria->active === true) {
                    $q->where('active', true);
                }
            });
        }

        if ($criteria->tagAliases !== []) {
            $query->whereIn('products.id', function ($subQuery) use ($criteria): void {
                $subQuery->select('product_tags.product_id')
                    ->from('product_tags')
                    ->join('tags', 'tags.id', '=', 'product_tags.tag_id')
                    ->whereIn('tags.alias', $criteria->tagAliases);

                if ($criteria->active === true) {
                    $subQuery->where('tags.active', true);
                }
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

        if ($criteria->featured !== null) {
            $query->where('products.featured', $criteria->featured);
        }

        $paginator = $query->paginate(perPage: $pageable->perPage, page: $pageable->page);

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (Product $product): DomainProduct => $product->toDomain(),
        );
    }

    #[Override]
    public function getMinOfferPrice(): ?int
    {
        $price = $this->query()
            ->where('active', true)
            ->whereHas('offers', fn ($q) => $q->where('active', true))
            ->withMin(['offers' => fn ($q) => $q->where('active', true)], 'price')
            ->orderBy('offers_min_price')
            ->value('offers_min_price');

        return $price !== null ? (int) $price : null;
    }

    #[Override]
    public function getMaxOfferPrice(): ?int
    {
        $price = $this->query()
            ->where('active', true)
            ->whereHas('offers', fn ($q) => $q->where('active', true))
            ->withMax(['offers' => fn ($q) => $q->where('active', true)], 'price')
            ->orderByDesc('offers_max_price')
            ->value('offers_max_price');

        return $price !== null ? (int) $price : null;
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
            'category_id' => $product->categoryId,
            'featured' => $product->featured,
        ];
    }

    private function offerAttributes(DomainOffer $offer): array
    {
        return [
            'id' => $offer->id->value,
            'active' => $offer->active,
            'sku' => $offer->sku,
            'name' => $offer->name,
            'sort' => $offer->sort,
            'description' => $offer->description,
            'price' => $offer->price,
            'stock_quantity' => $offer->stockQuantity,
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
            'name',
            'sort',
            'description',
            'price',
            'stock_quantity',
            'updated_at',
        ]);

        $offerPivotData = [];
        foreach ($offers as $offer) {
            $offerId = $offer->id->value;

            $offerPivotData[] = ['product_id' => $productId, 'offer_id' => $offerId];

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
        return $criteria->active === true
            || $criteria->sku !== null
            || $criteria->minPrice !== null
            || $criteria->maxPrice !== null
            || $criteria->inStock === true;
    }

    private function applyOfferCriteria(QueryBuilder $query, ProductSearchCriteria $criteria): void
    {
        if ($criteria->active !== null) {
            $query->where('active', $criteria->active);
        }

        if ($criteria->sku !== null) {
            $query->where('offers.sku', $criteria->sku);
        }

        if ($criteria->minPrice !== null) {
            $query->where('offers.price', '>=', $criteria->minPrice);
        }

        if ($criteria->maxPrice !== null) {
            $query->where('offers.price', '<=', $criteria->maxPrice);
        }

        if ($criteria->inStock === true) {
            $query->where('offers.stock_quantity', '>', 0);
        }
    }

    private function getSearchSortQuery(ProductSort $sort): Builder
    {
        return match ($sort) {
            ProductSort::PRICE_ASC => $this->query()
                ->withMin('offers', 'price')
                ->orderBy('offers_min_price'),
            ProductSort::PRICE_DESC => $this->query()
                ->withMin('offers', 'price')
                ->orderByDesc('offers_min_price'),
            ProductSort::SORT => $this->query()->orderByDesc('sort'),
        };
    }
}
