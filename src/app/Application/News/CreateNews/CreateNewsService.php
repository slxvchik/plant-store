<?php

declare(strict_types=1);

namespace App\Application\News\CreateNews;

use App\Application\News\Shared\Exception\NewsAliasExistsException;
use App\Domain\News\Model\News;
use App\Domain\News\Repository\NewsRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Override;

readonly class CreateNewsService implements CreateNewsUseCase
{
    public function __construct(
        private NewsRepository $newsRepository,
        private UuidGeneratorInterface $uuidGeneratorInterface
    ) {}

    /**
     * @throws NewsAliasExistsException
     */
    #[Override]
    public function execute(CreateNewsRequestDto $createNewsRequestDto): string
    {
        $newsExists = $this->newsRepository->findByAlias($createNewsRequestDto->alias) !== null;

        if ($newsExists) {
            throw new NewsAliasExistsException($createNewsRequestDto->alias);
        }

        $news = News::createNew(
            uuidIdentityGenerator: $this->uuidGeneratorInterface,
            alias: $createNewsRequestDto->alias,
            sort: $createNewsRequestDto->sort,
            name: $createNewsRequestDto->name,
            active: $createNewsRequestDto->active,
            description: $createNewsRequestDto->description,
        );

        return $this->newsRepository->create($news);
    }
}
