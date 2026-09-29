<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use App\Models\Warehouse;
use Override;

class WarehouseRepositoryImpl implements WarehouseRepository
{
    #[Override]
    public function findAll(): array
    {
        $warehouses = Warehouse::all();
        $domainWarehouses = [];
        foreach ($warehouses as $warehouse) {
            $domainWarehouses[] = $warehouse->toDomain();
        }
        return $domainWarehouses;
    }

    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function findById(string|int $id): ?object
    {
        $warehouse = Warehouse::find($id);
        return $warehouse->exists() ? $warehouse->toDomain() : null;
    }

    #[Override]
    public function findByIds(array $ids): array
    {
        $warehouses = Warehouse::find($ids)->toList();
        $domainWarehouses = [];
        foreach ($warehouses as $warehouse) {
            $domainWarehouses[] = $warehouse->toDomain();
        }
        return $domainWarehouses;
    }

    #[Override]
    public function create(object $entity): string
    {
        Warehouse::create([
            'id' => $entity->id->value,
            'address' => $entity->address,
            'phone' => $entity->phoneNumber
        ]);
        return $entity->id->value;
    }

    #[Override]
    public function update(object $entity): void
    {
        $warehouse = Warehouse::findOrFail($entity->id->value);
        $warehouse->address = $entity->address;
        $warehouse->phone = $entity->phoneNumber;
        $warehouse->save();
    }

    #[Override]
    public function delete(string $id): void
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();
    }
}
