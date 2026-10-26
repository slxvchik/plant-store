<?php

declare(strict_types=1);

namespace App\Domain\Warehouse\Repository;

use App\Domain\Warehouse\Model\Warehouse;

interface WarehouseRepository
{
    public function create(Warehouse $warehouse): string;

    public function update(Warehouse $warehouse): void;

    public function delete(string $id): void;

    public function findById(string $id): ?Warehouse;

    /**
     * @param  string[]  $ids
     * @return Warehouse[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Warehouse[]
     */
    public function findAll(): array;
}
