<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\ProductUnitStatus\Model\ProductUnitStatusModel as DomainProductUnitStatus;
use App\Domain\ProductUnitStatus\ProductUnitStatusRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Models\ProductUnitStatus;
use Override;

class ProductUnitStatusRepositoryImpl implements ProductUnitStatusRepository
{
    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        $paginator = ProductUnitStatus::query()
            ->orderBy('name')
            ->paginate(perPage: $pageable->perPage, page: $pageable->page);

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (ProductUnitStatus $status): DomainProductUnitStatus => $status->toDomain(),
        );
    }

    #[Override]
    public function findById(string $id): ?DomainProductUnitStatus
    {
        return ProductUnitStatus::find($id)?->toDomain();
    }

    #[Override]
    public function create(DomainProductUnitStatus $status): string
    {
        ProductUnitStatus::create($this->attributes($status));

        return $status->id->value;
    }

    #[Override]
    public function update(DomainProductUnitStatus $status): void
    {
        ProductUnitStatus::findOrFail($status->id->value)->update($this->attributes($status));
    }

    #[Override]
    public function delete(string $id): void
    {
        ProductUnitStatus::findOrFail($id)->delete();
    }

    /**
     * @return array{id: string, name: string, comment: ?string}
     */
    private function attributes(DomainProductUnitStatus $status): array
    {
        return ['id' => $status->id->value, 'name' => $status->name, 'comment' => $status->comment];
    }
}
