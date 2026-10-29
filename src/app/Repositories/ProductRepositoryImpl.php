<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Domain\Product\Model\Offer;
use App\Domain\Product\Model\Product;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Shared\SortedItem\SortedItem;
use App\Models\Product as ProductModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Override;

class ProductRepositoryImpl implements ProductRepository
{
    #[Override]
    public function create(Product $product): string
    {
        ProductModel::create($this->attributes($product));
        $this->syncRelations($product);

        return $product->id->value;
    }

    #[Override]
    public function update(Product $product): void
    {
        $model = ProductModel::findOrFail($product->id->value);

        $model->update($this->attributes($product));
        $this->syncRelations($product);
    }

    #[Override]
    public function delete(string $id): void
    {
        ProductModel::findOrFail($id)->delete();
    }

    #[Override]
    public function findById(string $id): ?Product
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
            ->map(fn (ProductModel $product): Product => $product->toDomain())
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
            mapper: fn (ProductModel $product): Product => $product->toDomain(),
        );
    }

    #[Override]
    public function findByAlias(string $alias): ?Product
    {
        return $this->query()->firstWhere('alias', $alias)?->toDomain();
    }

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
            mapper: fn (ProductModel $product): Product => $product->toDomain(),
        );
    }

    /**
     * @return Builder<ProductModel>
     */
    private function query(): Builder
    {
        return ProductModel::query()->with('offers');
    }

    /**
     * @return array<string, mixed>
     */
    private function attributes(Product $product): array
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

    private function syncRelations(Product $product): void
    {
        $productId = $product->id->value;

        $this->syncIds('product_categories', $productId, 'category_id', $product->categoryIds);
        $this->syncIds('product_tags', $productId, 'tag_id', $product->tagIds);
        $this->syncIds('product_offers', $productId, 'offer_id', array_map(
            fn (Offer $offer): string => $offer->id->value,
            $product->getOffers(),
        ));

        $this->syncSortedIds('product_images', $productId, 'image_id', $product->imageIds);
        $this->syncSortedIds('product_videos', $productId, 'video_id', $product->videoIds);
    }

    /**
     * @param  string[]  $ids
     */
    private function syncIds(string $table, string $productId, string $relatedColumn, array $ids): void
    {
        DB::table($table)->where('product_id', $productId)->delete();

        foreach ($ids as $id) {
            DB::table($table)->insert([
                'product_id' => $productId,
                $relatedColumn => $id,
            ]);
        }
    }

    /**
     * @param  SortedItem<string>[]  $sortedIds
     */
    private function syncSortedIds(string $table, string $productId, string $relatedColumn, array $sortedIds): void
    {
        DB::table($table)->where('product_id', $productId)->delete();

        foreach ($sortedIds as $sortedId) {
            DB::table($table)->insert([
                'product_id' => $productId,
                $relatedColumn => $sortedId->id,
                'sort' => $sortedId->sort,
            ]);
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
