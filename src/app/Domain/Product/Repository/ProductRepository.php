<?php

declare(strict_types=1);

namespace App\Domain\Product\Repository;

use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Domain\Product\Model\Product;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface ProductRepository
{
    public function create(Product $product): string;

    public function update(Product $product): void;

    public function delete(string $id): void;

    public function findById(string $id): ?Product;

    /**
     * @param  string[]  $ids
     * @return Product[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Page<Product>
     */
    public function findPage(Pageable $pageable): Page;

    public function findByAlias(string $alias): ?Product;

    /**
     * @return Page<Product>
     */
    public function search(ProductSearchCriteria $criteria, Pageable $pageable): Page;
}
