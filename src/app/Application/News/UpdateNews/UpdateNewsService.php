<?php

declare(strict_types=1);

namespace App\Application\News\UpdateNews;

use App\Application\News\Shared\Exception\NewsAliasExistsException;
use App\Application\News\Shared\Exception\NewsNotFoundException;
use App\Domain\News\Repository\NewsRepository;
use Override;

readonly class UpdateNewsService implements UpdateNewsUseCase
{
    public function __construct(
        private NewsRepository $newsRepository
    ) {}

    /**
     * @throws NewsNotFoundException
     * @throws NewsAliasExistsException
     */
    #[Override]
    public function execute(UpdateNewsRequestDto $updateNewsRequestDto): void
    {
        $news = $this->newsRepository->findById($updateNewsRequestDto->id);
        if ($news === null) {
            throw new NewsNotFoundException;
        }

        $news->update(
            alias: $updateNewsRequestDto->alias,
            sort: $updateNewsRequestDto->sort,
            name: $updateNewsRequestDto->name,
            active: $updateNewsRequestDto->active,
            description: $updateNewsRequestDto->description,
        );

        $existingNews = $this->newsRepository->findByAlias($news->alias);

        if ($existingNews !== null && $existingNews->id->value !== $news->id->value) {
            throw new NewsAliasExistsException($news->alias);
        }

        $this->newsRepository->update($news);
    }
}
