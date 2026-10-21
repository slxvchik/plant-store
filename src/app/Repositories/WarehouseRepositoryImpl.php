<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use App\Models\Warehouse;
use Exception;
use Override;

class WarehouseRepositoryImpl implements WarehouseRepository
{
    #[Override]
    public function findAll(): array
    {
        return Warehouse::all()
            ->map(fn (Warehouse $warehouse) => $warehouse->toDomain())
            ->all();
    }

    /**
     * @throws Exception
     */
    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function findById(string|int $id): ?object
    {
        return Warehouse::find($id)?->toDomain();
    }

    #[Override]
    public function findByIds(array $ids): array
    {
        return Warehouse::whereIn('id', $ids)
            ->get()
            ->map(fn (Warehouse $warehouse) => $warehouse->toDomain())
            ->all();
    }

    #[Override]
    public function create(object $entity): string
    {
        Warehouse::create([
            'id' => $entity->id->value,
            'address' => $entity->address,
            'phone' => $entity->phoneNumber,
        ]);

        return $entity->id->value;
    }

    #[Override]
    public function update(object $entity): void
    {
        Warehouse::findOrFail($entity->id->value)->update([
            'address' => $entity->address,
            'phone' => $entity->phoneNumber,
        ]);
    }

    #[Override]
    public function delete(string $id): void
    {
        Warehouse::findOrFail($id)->delete();
    }
}
