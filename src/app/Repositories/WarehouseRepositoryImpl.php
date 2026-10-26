<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Domain\Warehouse\Model\Warehouse as DomainWarehouse;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use App\Models\Warehouse;
use Override;

class WarehouseRepositoryImpl implements WarehouseRepository
{
    #[Override]
    public function create(DomainWarehouse $warehouse): string
    {
        Warehouse::create($this->attributes($warehouse));

        return $warehouse->id->value;
    }

    #[Override]
    public function update(DomainWarehouse $warehouse): void
    {
        Warehouse::findOrFail($warehouse->id->value)->update($this->attributes($warehouse));
    }

    #[Override]
    public function delete(string $id): void
    {
        Warehouse::findOrFail($id)->delete();
    }

    #[Override]
    public function findById(string $id): ?DomainWarehouse
    {
        return Warehouse::find($id)?->toDomain();
    }

    #[Override]
    public function findByIds(array $ids): array
    {
        return Warehouse::whereIn('id', $ids)
            ->get()
            ->map(fn (Warehouse $warehouse): DomainWarehouse => $warehouse->toDomain())
            ->all();
    }

    #[Override]
    public function findAll(): array
    {
        return Warehouse::all()
            ->map(fn (Warehouse $warehouse): DomainWarehouse => $warehouse->toDomain())
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function attributes(DomainWarehouse $warehouse): array
    {
        return [
            'id' => $warehouse->id->value,
            'address' => $warehouse->address,
            'phone' => $warehouse->phoneNumber,
        ];
    }
}
