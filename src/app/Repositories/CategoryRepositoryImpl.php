<?php

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\Category\Model\Category as DomainCategoryModel;
use App\Domain\Category\Repository\CategoryRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use LogicException;
use Override;

class CategoryRepositoryImpl implements CategoryRepository
{
    /**
     * @param  DomainCategoryModel  $entity
     *
     * @throws ModelNotFoundException
     */
    #[Override]
    public function update(object $entity): void
    {
        Category::findOrFail($entity->id->value)->update([
            'parent_id' => $entity->parentId?->value,
            'alias' => $entity->alias,
            'sort' => $entity->sort,
            'name' => $entity->name,
            'active' => $entity->active,
        ]);
    }

    /**
     * @param  DomainCategoryModel  $entity
     */
    #[Override]
    public function create(object $entity): string
    {
        $created = Category::create([
            'id' => $entity->id->value,
            'parent_id' => $entity->parentId?->value,
            'alias' => $entity->alias,
            'sort' => $entity->sort,
            'name' => $entity->name,
            'active' => $entity->active,
        ]);

        return $created->id;
    }

    /**
     * @throws ModelNotFoundException
     * @throws LogicException
     */
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
        return Category::find($ids)->map(function (Category $category) {
            return $category->toDomain();
        })->toArray();
    }

    /**
     * @throws InvalidArgumentException
     */
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
        return Category::all()->map(function (Category $category) {
            return $category->toDomain();
        })->toArray();
    }

    #[Override]
    public function findByAlias(string $alias): ?DomainCategoryModel
    {
        return Category::firstWhere('alias', $alias)?->toDomain();
    }
}
