<?php

namespace App\Repositories;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Tag\Model\Tag;
use App\Domain\Tag\Repository\TagRepository;

class TagRepositoryImpl implements TagRepository
{
    #[\Override]
    function create(object $entity): string
    {

    }

    function update(object $entity): void
    {
        // TODO: Implement update() method.
    }

    function delete(string $id): void
    {
        // TODO: Implement delete() method.
    }

    function findById(int|string $id): ?object
    {
        // TODO: Implement findById() method.
    }

    function findByIds(array $ids): array
    {
        // TODO: Implement findByIds() method.
    }

    function findPage(Pageable $pageable): Page
    {
        // TODO: Implement findPage() method.
    }

    function findAll(): array
    {

    }

    public function findByAlias(string $alias): Tag
    {
        // TODO: Implement findByAlias() method.
    }
}
