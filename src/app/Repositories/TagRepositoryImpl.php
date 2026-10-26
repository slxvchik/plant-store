<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Tag\Model\Tag as DomainTag;
use App\Domain\Tag\Repository\TagRepository;
use App\Models\Tag;
use Override;

class TagRepositoryImpl implements TagRepository
{
    #[Override]
    public function create(DomainTag $tag): string
    {
        $created = Tag::create($this->attributes($tag));

        return $created->id;
    }

    #[Override]
    public function update(DomainTag $tag): void
    {
        Tag::findOrFail($tag->id->value)->update($this->attributes($tag));
    }

    #[Override]
    public function delete(string $id): void
    {
        Tag::findOrFail($id)->delete();
    }

    #[Override]
    public function findById(string $id): ?DomainTag
    {
        return Tag::find($id)?->toDomain();
    }

    #[Override]
    public function findByIds(array $ids): array
    {
        return Tag::whereIn('id', $ids)
            ->orderBy('sort')
            ->get()
            ->map(fn (Tag $tag): DomainTag => $tag->toDomain())
            ->all();
    }

    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        $paginator = Tag::query()->paginate(
            perPage: $pageable->perPage,
            page: $pageable->page,
        );

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (Tag $tag): DomainTag => $tag->toDomain(),
        );
    }

    #[Override]
    public function findByAlias(string $alias): ?DomainTag
    {
        return Tag::firstWhere('alias', $alias)?->toDomain();
    }

    /**
     * @return array<string, mixed>
     */
    private function attributes(DomainTag $tag): array
    {
        return [
            'id' => $tag->id->value,
            'alias' => $tag->alias,
            'sort' => $tag->sort,
            'name' => $tag->name,
            'active' => $tag->active,
        ];
    }
}
