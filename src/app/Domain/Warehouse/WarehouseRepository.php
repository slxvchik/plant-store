<?php

declare(strict_types=1);

namespace App\Domain\Warehouse;

interface WarehouseRepository
{
    public function create(WarehouseModel $warehouse): string;

    public function update(WarehouseModel $warehouse): void;

    public function delete(string $id): void;

    public function findById(string $id): ?WarehouseModel;

    /**
     * @param  string[]  $ids
     * @return WarehouseModel[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return WarehouseModel[]
     */
    public function findAll(): array;
}
