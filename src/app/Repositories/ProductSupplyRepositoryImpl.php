<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\ProductSupply\ProductSupplyModel as DomainProductSupply;
use App\Domain\ProductSupply\ProductSupplyRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Models\ProductSupply;
use Override;

class ProductSupplyRepositoryImpl implements ProductSupplyRepository
{
    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        $paginator = ProductSupply::query()
            ->orderByDesc('created_at')
            ->paginate(perPage: $pageable->perPage, page: $pageable->page);

        return $this->toDomainPage($paginator);
    }

    #[Override]
    public function findPageBySupplierId(string $supplierId, Pageable $pageable): Page
    {
        $paginator = ProductSupply::query()
            ->where('supplier_id', $supplierId)
            ->orderByDesc('created_at')
            ->paginate(perPage: $pageable->perPage, page: $pageable->page);

        return $this->toDomainPage($paginator);
    }

    #[Override]
    public function findById(string $id): ?DomainProductSupply
    {
        return ProductSupply::find($id)?->toDomain();
    }

    #[Override]
    public function create(DomainProductSupply $productSupply): string
    {
        ProductSupply::create($this->attributes($productSupply));

        return $productSupply->id->value;
    }

    #[Override]
    public function update(DomainProductSupply $productSupply): void
    {
        ProductSupply::findOrFail($productSupply->id->value)->update($this->attributes($productSupply));
    }

    #[Override]
    public function delete(string $id): void
    {
        ProductSupply::findOrFail($id)->delete();
    }

    /**
     * @param  \Illuminate\Pagination\LengthAwarePaginator<int, ProductSupply>  $paginator
     * @return Page<DomainProductSupply>
     */
    private function toDomainPage(\Illuminate\Pagination\LengthAwarePaginator $paginator): Page
    {
        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (ProductSupply $productSupply): DomainProductSupply => $productSupply->toDomain(),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function attributes(DomainProductSupply $productSupply): array
    {
        return [
            'id' => $productSupply->id->value,
            'supplier_id' => $productSupply->supplierId,
            'offer_id' => $productSupply->offerId,
            'declared_quantity' => $productSupply->declaredQuantity,
            'actual_quantity' => $productSupply->actualQuantity,
            'unit_purchase_price_in_kopecks' => $productSupply->unitPurchasePriceInKopecks,
            'total_purchase_price_in_kopecks' => $productSupply->totalPurchasePriceInKopecks,
            'comment' => $productSupply->comment,
            'mis_graded' => $productSupply->misGraded,
        ];
    }
}
