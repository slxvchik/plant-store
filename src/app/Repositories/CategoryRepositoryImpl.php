<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\Category\Model\Category as DomainCategory;
use App\Domain\Category\Repository\CategoryRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Models\Category;
use Override;

class CategoryRepositoryImpl implements CategoryRepository
{
    #[Override]
    public function create(DomainCategory $category): string
    {
        $created = Category::create($this->attributes($category));

        return $created->id;
    }

    #[Override]
    public function update(DomainCategory $category): void
    {
        Category::findOrFail($category->id->value)->update($this->attributes($category));
    }

    #[Override]
    public function delete(string $id): void
    {
        Category::findOrFail($id)->delete();
    }

    #[Override]
    public function findById(string $id): ?DomainCategory
    {
        return Category::find($id)?->toDomain();
    }

    #[Override]
    public function findByIds(array $ids): array
    {
        return Category::find($ids)
            ->map(fn (Category $category): DomainCategory => $category->toDomain())
            ->all();
    }

    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        $paginator = Category::query()->paginate(
            perPage: $pageable->perPage,
            page: $pageable->page,
        );

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (Category $category): DomainCategory => $category->toDomain(),
        );
    }

    #[Override]
    public function findAll(): array
    {
        return Category::all()
            ->map(fn (Category $category): DomainCategory => $category->toDomain())
            ->all();
    }

    #[Override]
    public function findByAlias(string $alias): ?DomainCategory
    {
        return Category::firstWhere('alias', $alias)?->toDomain();
    }

    /**
     * @return array<string, mixed>
     */
    private function attributes(DomainCategory $category): array
    {
        return [
            'id' => $category->id->value,
            'parent_id' => $category->parentId?->value,
            'alias' => $category->alias,
            'sort' => $category->sort,
            'name' => $category->name,
            'active' => $category->active,
        ];
    }
}
