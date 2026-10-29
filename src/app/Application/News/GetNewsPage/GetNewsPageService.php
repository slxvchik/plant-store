<?php

declare(strict_types=1);

namespace App\Application\News\GetNewsPage;

use App\Application\News\Shared\Dto\Response\NewsResponseDto;
use App\Domain\News\Repository\NewsRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use Override;

readonly class GetNewsPageService implements GetNewsPageUseCase
{
    public function __construct(
        private NewsRepository $newsRepository
    ) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        $page = $this->newsRepository->findPage($pageable);

        $newsResponseDtos = [];
        foreach ($page->items as $news) {
            $newsResponseDtos[] = NewsResponseDto::fromDomain($news);
        }

        return $page->changeItems($newsResponseDtos);
    }
}
