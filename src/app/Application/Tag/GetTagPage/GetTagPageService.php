<?php

declare(strict_types=1);

namespace App\Application\Tag\GetTagPage;

use App\Application\Tag\Shared\Dto\Response\TagResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Tag\Repository\TagRepository;
use Override;

readonly class GetTagPageService implements GetTagPageUseCase
{
    public function __construct(
        private TagRepository $tagRepository
    ) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        $page = $this->tagRepository->findPage($pageable);

        $tagResponseDtos = [];
        foreach ($page->items as $tag) {
            $tagResponseDtos[] = TagResponseDto::fromDomain($tag);
        }

        return $page->changeItems($tagResponseDtos);
    }
}
