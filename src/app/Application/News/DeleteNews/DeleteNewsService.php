<?php

declare(strict_types=1);

namespace App\Application\News\DeleteNews;

use App\Application\News\Shared\Exception\NewsNotFoundException;
use App\Domain\News\Repository\NewsRepository;
use Override;

readonly class DeleteNewsService implements DeleteNewsUseCase
{
    public function __construct(
        private NewsRepository $newsRepository
    ) {}

    /**
     * @throws NewsNotFoundException
     */
    #[Override]
    public function execute(string $id): void
    {
        if ($this->newsRepository->findById($id) === null) {
            throw new NewsNotFoundException($id);
        }

        $this->newsRepository->delete($id);
    }
}
