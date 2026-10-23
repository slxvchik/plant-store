<?php

namespace App\Repositories;

use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Domain\Product\Model\Product;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

class ProductRepositoryImpl implements ProductRepository
{

    public function create(object $entity): string
    {
        // TODO: Implement create() method.
    }

    public function update(object $entity): void
    {
        // TODO: Implement update() method.
    }

    public function delete(string $id): void
    {
        // TODO: Implement delete() method.
    }

    public function findById(int|string $id): ?object
    {
        // TODO: Implement findById() method.
    }

    public function findByIds(array $ids): array
    {
        // TODO: Implement findByIds() method.
    }

    public function findPage(Pageable $pageable): Page
    {
        // TODO: Implement findPage() method.
    }

    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    public function findByAlias(string $alias): ?Product
    {
        // TODO: Implement findByAlias() method.
    }

    public function search(ProductSearchCriteria $criteria, Pageable $pageable): Page
    {
        // TODO: Implement search() method.
    }
}
