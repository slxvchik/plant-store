<?php

namespace App\Domain\ProductSupply;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface ProductSupplyRepository
{
    public function findById(int $id): ?ProductSupplyModel;
    public function findPageBySupplierId(string $supplierId, Pageable $pageable): Page;
}
