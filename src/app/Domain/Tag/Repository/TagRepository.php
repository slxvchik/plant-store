<?php

declare(strict_types=1);

namespace App\Domain\Tag\Repository;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Tag\Model\Tag;

interface TagRepository
{
    public function create(Tag $tag): string;

    public function update(Tag $tag): void;

    public function delete(string $id): void;

    public function findById(string $id): ?Tag;

    /**
     * @param  string[]  $ids
     * @return Tag[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Page<Tag>
     */
    public function findPage(Pageable $pageable): Page;

    public function findByAlias(string $alias): ?Tag;
}
