<?php

declare(strict_types=1);

namespace App\Application\Tag\Service;

use App\Application\Tag\UseCase\GetTagPageUseCase;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Tag\Repository\TagRepository;
use Override;

class GetTagPageService implements GetTagPageUseCase
{
    public function __construct(
        private final TagRepository $tagRepository
    ) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        return $this->tagRepository->findPage($pageable);
    }
}
