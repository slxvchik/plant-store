<?php

namespace App\Repositories;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Tag\Model\Tag;
use App\Domain\Tag\Repository\TagRepository;
use Override;

class TagRepositoryImpl implements TagRepository
{
    #[Override]
    function create(object $entity): string
    {

    }

    #[Override]
    function update(object $entity): void
    {
        // TODO: Implement update() method.
    }

    #[Override]
    function delete(string $id): void
    {
        // TODO: Implement delete() method.
    }

    #[Override]
    function findById(int|string $id): ?object
    {
        // TODO: Implement findById() method.
    }

    #[Override]
    function findByIds(array $ids): array
    {
        // TODO: Implement findByIds() method.
    }

    #[Override]
    function findPage(Pageable $pageable): Page
    {
        // TODO: Implement findPage() method.
    }

    #[Override]
    function findAll(): array
    {

    }

    #[Override]
    public function findByAlias(string $alias): Tag
    {
        // TODO: Implement findByAlias() method.
    }
}
