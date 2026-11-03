<?php

declare(strict_types=1);

namespace App\Application\News\GetNews;

use App\Application\News\Shared\Dto\Response\NewsResponseDto;
use App\Application\News\Shared\Exception\NewsNotFoundException;
use App\Domain\News\Repository\NewsRepository;
use Override;

readonly class GetNewsService implements GetNewsUseCase
{
    public function __construct(
        private NewsRepository $newsRepository
    ) {}

    /**
     * @throws NewsNotFoundException
     */
    #[Override]
    public function execute(string $id): NewsResponseDto
    {
        $news = $this->newsRepository->findById($id);
        if ($news === null) {
            throw new NewsNotFoundException($id);
        }

        return NewsResponseDto::fromDomain($news);
    }
}
