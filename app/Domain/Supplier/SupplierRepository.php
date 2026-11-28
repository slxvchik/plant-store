<?php

declare(strict_types=1);

namespace App\Domain\Supplier;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface SupplierRepository
{
    /**
     * @return Page<SupplierModel>
     */
    public function findPage(Pageable $pageable, ?string $search = null): Page;

    /**
     * @return SupplierModel[]
     */
    public function findAll(): array;

    public function findById(string $id): ?SupplierModel;

    public function findByName(string $name): ?SupplierModel;

    public function findByEmail(string $email): ?SupplierModel;

    public function create(SupplierModel $supplier): string;

    public function update(SupplierModel $supplier): void;

    public function delete(string $id): void;
}
