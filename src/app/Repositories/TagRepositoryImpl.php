<?php

namespace App\Repositories;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Tag\Model\Tag as DomainTagModel;
use App\Domain\Tag\Repository\TagRepository;
use App\Models\Tag;
use App\Pagination\PaginationAdapter;
use Exception;
use Override;

class TagRepositoryImpl implements TagRepository
{
    #[Override]
    function create(object $entity): string
    {
        $created = Tag::create([
            'id' => $entity->id,
            'alias' => $entity->alias,
            'sort' => $entity->sort,
            'name' => $entity->name,
            'active' => $entity->active,
        ]);
        return $created->id;
    }

    #[Override]
    function update(object $entity): void
    {
        Tag::findOrFail($entity->id->value)->update([
            'alias' => $entity->alias,
            'sort' => $entity->sort,
            'name' => $entity->name,
            'active' => $entity->active,
        ]);
    }

    #[Override]
    function delete(string $id): void
    {
        Tag::findOrFail($id)->delete();
    }

    #[Override]
    function findById(int|string $id): ?object
    {
        return Tag::find($id)?->toDomain();
    }

    /**
     * @param string[] $ids
     * @return DomainTagModel[]
     */
    #[Override]
    function findByIds(array $ids): array
    {
        return Tag::whereIn('id', $ids)
            ->orderBy('sort')
            ->get()
            ->map(fn (Tag $tag) => $tag->toDomain())
            ->all();
    }

    #[Override]
    function findPage(Pageable $pageable): Page
    {
        $paginator = Tag::query()->paginate(
            perPage: $pageable->perPage,
            page: $pageable->page,
        );
        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn(Tag $tag) => $tag->toDomain(),
        );
    }

    /**
     * @throws Exception
     */
    #[Override]
    function findAll(): array
    {
        throw new Exception("Not implemented");
    }

    #[Override]
    public function findByAlias(string $alias): ?DomainTagModel
    {
        return Tag::firstWhere('alias', $alias)?->toDomain();
    }
}
