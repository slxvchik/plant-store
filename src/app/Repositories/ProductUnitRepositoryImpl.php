<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\ProductUnit\ProductUnitCriteria;
use App\Domain\ProductUnit\ProductUnitModel as DomainProductUnit;
use App\Domain\ProductUnit\ProductUnitRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Models\ProductUnit;
use Override;

class ProductUnitRepositoryImpl implements ProductUnitRepository
{
    #[Override]
    public function findPage(Pageable $pageable, ?ProductUnitCriteria $criteria = null): Page
    {
        $query = ProductUnit::query()->orderByDesc('created_at');

        if ($criteria?->offerId !== null) {
            $query->where('offer_id', $criteria->offerId);
        }
        if ($criteria?->warehouseId !== null) {
            $query->where('warehouse_id', $criteria->warehouseId);
        }
        if ($criteria?->productUnitStatusId !== null) {
            $query->where('product_unit_status_id', $criteria->productUnitStatusId);
        }
        if ($criteria?->productSupplyId !== null) {
            $query->where('product_supply_id', $criteria->productSupplyId);
        }

        $paginator = $query->paginate(perPage: $pageable->perPage, page: $pageable->page);

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (ProductUnit $productUnit): DomainProductUnit => $productUnit->toDomain(),
        );
    }

    #[Override]
    public function findBySupplyId(string $supplyId): array
    {
        return ProductUnit::query()->where('product_supply_id', $supplyId)->orderBy('created_at')->get()
            ->map(fn (ProductUnit $productUnit): DomainProductUnit => $productUnit->toDomain())->all();
    }

    #[Override]
    public function findById(string $id): ?DomainProductUnit
    {
        return ProductUnit::find($id)?->toDomain();
    }

    #[Override]
    public function findByQrCode(string $qrCode): ?DomainProductUnit
    {
        return ProductUnit::firstWhere('qr_code', $qrCode)?->toDomain();
    }

    #[Override]
    public function create(DomainProductUnit $productUnit): string
    {
        ProductUnit::create($this->attributes($productUnit));

        return $productUnit->id->value;
    }

    #[Override]
    public function createMany(array $productUnits): void
    {
        if ($productUnits === []) {
            return;
        }

        $timestamp = now();
        $rows = array_map(function (DomainProductUnit $productUnit) use ($timestamp): array {
            return [...$this->attributes($productUnit), 'created_at' => $timestamp, 'updated_at' => $timestamp];
        }, $productUnits);

        ProductUnit::insert($rows);
    }

    #[Override]
    public function update(DomainProductUnit $productUnit): void
    {
        ProductUnit::findOrFail($productUnit->id->value)->update($this->attributes($productUnit));
    }

    #[Override]
    public function delete(string $id): void
    {
        ProductUnit::findOrFail($id)->delete();
    }

    /**
     * @return array<string, mixed>
     */
    private function attributes(DomainProductUnit $productUnit): array
    {
        return [
            'id' => $productUnit->id->value,
            'product_supply_id' => $productUnit->productSupplyId,
            'offer_id' => $productUnit->offerId,
            'warehouse_id' => $productUnit->warehouseId,
            'reserved' => $productUnit->reserved,
            'sowing_date' => $productUnit->sowingDate,
            'product_unit_status_id' => $productUnit->productUnitStatusId,
            'comments' => $productUnit->comments,
            'qr_code' => $productUnit->qrCode,
        ];
    }
}
