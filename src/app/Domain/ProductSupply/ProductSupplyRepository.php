<?php

declare(strict_types=1);

namespace App\Domain\ProductSupply;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface ProductSupplyRepository
{
    /**
     * @return Page<ProductSupplyModel>
     */
    public function findPage(Pageable $pageable): Page;

    /**
     * @return Page<ProductSupplyModel>
     */
    public function findPageBySupplierId(string $supplierId, Pageable $pageable): Page;

    public function findById(string $id): ?ProductSupplyModel;

    public function create(ProductSupplyModel $productSupply): string;

    public function update(ProductSupplyModel $productSupply): void;

    public function delete(string $id): void;
}
