<?php

namespace App\Domain\Supplier;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface SupplierRepository
{
    /**
     * @return Page<SupplierModel>
     */
    public function findPage(Pageable $pageable): Page;

    public function findById(string $id): ?SupplierModel;

    public function create(SupplierModel $supplier): void;

    public function update(SupplierModel $supplier): void;

    public function delete(string $id): void;
}
