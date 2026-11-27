<?php

declare(strict_types=1);

namespace App\Domain\ProductUnit;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface ProductUnitRepository
{
    /**
     * @return Page<ProductUnitModel>
     */
    public function findPage(Pageable $pageable, ?ProductUnitCriteria $criteria = null): Page;

    /**
     * @return ProductUnitModel[]
     */
    public function findBySupplyId(string $supplyId): array;

    public function findById(string $id): ?ProductUnitModel;

    public function create(ProductUnitModel $productUnit): string;

    /**
     * @param  ProductUnitModel[]  $productUnits
     */
    public function createMany(array $productUnits): void;

    public function update(ProductUnitModel $productUnit): void;

    public function delete(string $id): void;
}
