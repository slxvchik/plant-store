<?php

declare(strict_types=1);

namespace App\Domain\Category;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface CategoryRepository
{
    public function create(CategoryModel $category): string;

    public function update(CategoryModel $category): void;

    public function delete(string $id): void;

    public function findById(string $id): ?CategoryModel;

    /**
     * @param  string[]  $ids
     * @return CategoryModel[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Page<CategoryModel>
     */
    public function findPage(Pageable $pageable): Page;

    /**
     * @return CategoryModel[]
     */
    public function findAll(): array;

    public function findByAlias(string $alias): ?CategoryModel;
}
