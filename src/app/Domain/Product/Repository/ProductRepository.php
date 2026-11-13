<?php

declare(strict_types=1);

namespace App\Domain\Product\Repository;

use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Domain\Product\Model\ProductModel;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface ProductRepository
{
    public function create(ProductModel $product): string;

    public function update(ProductModel $product): void;

    public function delete(string $id): void;

    public function findById(string $id): ?ProductModel;

    /**
     * @param  string[]  $ids
     * @return ProductModel[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Page<ProductModel>
     */
    public function findPage(Pageable $pageable): Page;

    public function findByAlias(string $alias): ?ProductModel;

    /**
     * @return Page<ProductModel>
     */
    public function search(ProductSearchCriteria $criteria, Pageable $pageable): Page;
}
