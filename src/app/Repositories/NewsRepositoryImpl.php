<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\News\Model\News;
use App\Domain\News\Repository\NewsRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Models\News as NewsModel;
use Override;

class NewsRepositoryImpl implements NewsRepository
{
    #[Override]
    public function create(News $news): string
    {
        NewsModel::create($this->attributes($news));

        return $news->id->value;
    }

    #[Override]
    public function update(News $news): void
    {
        NewsModel::findOrFail($news->id->value)->update($this->attributes($news));
    }

    #[Override]
    public function delete(string $id): void
    {
        NewsModel::findOrFail($id)->delete();
    }

    #[Override]
    public function findById(string $id): ?News
    {
        return NewsModel::find($id)?->toDomain();
    }

    #[Override]
    public function findByAlias(string $alias): ?News
    {
        return NewsModel::firstWhere('alias', $alias)?->toDomain();
    }

    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        $paginator = NewsModel::query()
            ->orderBy('sort')
            ->paginate(perPage: $pageable->perPage, page: $pageable->page);

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (NewsModel $news): News => $news->toDomain(),
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function attributes(News $news): array
    {
        return [
            'id' => $news->id->value,
            'alias' => $news->alias,
            'sort' => $news->sort,
            'name' => $news->name,
            'active' => $news->active,
            'description' => $news->description,
        ];
    }
}
