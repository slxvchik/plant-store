<?php

namespace App\Repositories;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Tag\Model\Tag as DomainTagModel;
use App\Domain\Tag\Repository\TagRepository;
use App\Models\Tag;
use App\Pagination\PaginationAdapter;
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
        $tag = Tag::findOrFail($entity->id->value);
        $tag->alias = $entity->alias;
        $tag->sort = $entity->sort;
        $tag->name = $entity->name;
        $tag->active = $entity->active;
        $tag->save();
    }

    #[Override]
    function delete(string $id): void
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();
    }

    #[Override]
    function findById(int|string $id): ?object
    {
        $tag = Tag::find($id);
        return $tag->exists() ? $tag->toDomain() : null;
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
            ->map(function (Tag $tag) {
                return $tag->toDomain();
            })->all();
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

    #[Override]
    function findAll(): array
    {
        throw new \Exception("Not implemented");
    }

    #[Override]
    public function findByAlias(string $alias): ?DomainTagModel
    {
        $tag = Tag::where('alias', $alias);
        return $tag->exists() ? $tag->toDomain() : null;
    }
}
