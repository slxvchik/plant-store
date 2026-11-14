<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Supplier\SupplierModel as DomainSupplier;
use App\Domain\Supplier\SupplierRepository;
use App\Models\Supplier;
use Override;

class SupplierRepositoryImpl implements SupplierRepository
{
    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        $paginator = Supplier::query()
            ->orderBy('name')
            ->paginate(perPage: $pageable->perPage, page: $pageable->page);

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (Supplier $supplier): DomainSupplier => $supplier->toDomain(),
        );
    }

    #[Override]
    public function findById(string $id): ?DomainSupplier
    {
        return Supplier::find($id)?->toDomain();
    }

    #[Override]
    public function create(DomainSupplier $supplier): string
    {
        Supplier::create($this->attributes($supplier));

        return $supplier->id->value;
    }

    #[Override]
    public function update(DomainSupplier $supplier): void
    {
        Supplier::findOrFail($supplier->id->value)->update($this->attributes($supplier));
    }

    #[Override]
    public function delete(string $id): void
    {
        Supplier::findOrFail($id)->delete();
    }

    /**
     * @return array<string, mixed>
     */
    private function attributes(DomainSupplier $supplier): array
    {
        return [
            'id' => $supplier->id->value,
            'name' => $supplier->name,
            'phone' => $supplier->phone,
            'email' => $supplier->email,
            'address' => $supplier->address,
            'comment' => $supplier->comment,
        ];
    }
}
