<?php

namespace App\Repositories;

use App\Domain\Category\Model\Category as DomainCategoryModel;
use App\Domain\Category\Repository\CategoryRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Models\Category;
use App\Pagination\PaginationAdapter;
use Exception;
use Override;

class CategoryRepositoryImpl implements CategoryRepository
{
    #[Override]
    public function create(object $entity): string
    {
        $created = Category::create([
            'id' => $entity->id->value,
            'alias' => $entity->alias,
            'sort' => $entity->sort,
            'name' => $entity->name,
            'active' => $entity->active,
        ]);

        return $created->id;
    }

    #[Override]
    public function update(object $entity): void
    {
        Category::findOrFail($entity->id->value)->update([
            'alias' => $entity->alias,
            'sort' => $entity->sort,
            'name' => $entity->name,
            'active' => $entity->active,
        ]);
    }

    #[Override]
    public function delete(string $id): void
    {
        Category::findOrFail($id)->delete();
    }

    #[Override]
    public function findById(int|string $id): ?object
    {
        return Category::find($id)?->toDomain();
    }

    /**
     * @throws Exception
     */
    #[Override]
    public function findByIds(array $ids): array
    {
        throw new Exception('Not implemented');
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
            mapper: fn (Category $category) => $category->toDomain(),
        );
    }

    /**
     * @throws Exception
     */
    #[Override]
    public function findAll(): array
    {
        throw new Exception('Not implemented');
    }

    #[Override]
    public function findByAlias(string $alias): ?DomainCategoryModel
    {
        return Category::firstWhere('alias', $alias)?->toDomain();
    }
}
