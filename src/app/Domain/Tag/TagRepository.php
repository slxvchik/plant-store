<?php

declare(strict_types=1);

namespace App\Domain\Tag;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface TagRepository
{
    public function create(TagModel $tag): string;

    public function update(TagModel $tag): void;

    public function delete(string $id): void;

    public function findById(string $id): ?TagModel;

    /**
     * @param  string[]  $ids
     * @return TagModel[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Page<TagModel>
     */
    public function findPage(Pageable $pageable): Page;

    public function findByAlias(string $alias): ?TagModel;
}
