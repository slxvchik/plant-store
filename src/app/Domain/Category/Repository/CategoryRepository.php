<?php

declare(strict_types=1);

namespace App\Domain\Category\Repository;

use App\Domain\Category\Model\Category;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface CategoryRepository
{
    public function create(Category $category): string;

    public function update(Category $category): void;

    public function delete(string $id): void;

    public function findById(string $id): ?Category;

    /**
     * @param  string[]  $ids
     * @return Category[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Page<Category>
     */
    public function findPage(Pageable $pageable): Page;

    /**
     * @return Category[]
     */
    public function findAll(): array;

    public function findByAlias(string $alias): ?Category;
}
