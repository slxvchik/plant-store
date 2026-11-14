<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\ProductUnit\ProductUnitModel as DomainProductUnit;
use App\Domain\ProductUnit\ProductUnitRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Models\ProductUnit;
use Override;

class ProductUnitRepositoryImpl implements ProductUnitRepository
{
    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        $paginator = ProductUnit::query()
            ->orderByDesc('created_at')
            ->paginate(perPage: $pageable->perPage, page: $pageable->page);

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (ProductUnit $productUnit): DomainProductUnit => $productUnit->toDomain(),
        );
    }

    #[Override]
    public function findById(string $id): ?DomainProductUnit
    {
        return ProductUnit::find($id)?->toDomain();
    }

    #[Override]
    public function create(DomainProductUnit $productUnit): string
    {
        ProductUnit::create($this->attributes($productUnit));

        return $productUnit->id->value;
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
