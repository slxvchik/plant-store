<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Warehouse\Repository\WarehouseRepository;
use Override;

class WarehouseRepositoryImpl implements WarehouseRepository
{
    #[Override]
    public function findAll(): array
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function findById(string|int $id): ?object
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function findByIds(array $ids): array
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function create(object $entity): string
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function update(object $entity): void
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function delete(string $id): void
    {
        throw new \Exception('Not implemented');
    }
}
