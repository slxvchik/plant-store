<?php

declare(strict_types=1);

namespace App\Application\Category\GetCategories;

use App\Application\Category\Shared\Dto\Response\CategoryResponseDto;
use App\Domain\Category\Repository\CategoryRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use Override;

readonly class GetCategoriesService implements GetCategoriesUseCase
{
    public function __construct(
        final private CategoryRepository $categoryRepository
    ) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        $page = $this->categoryRepository->findPage($pageable);

        $categoryResponseDtos = [];
        foreach ($page->items as $category) {
            $categoryResponseDtos[] = CategoryResponseDto::fromDomain($category);
        }

        return $page->changeItems($categoryResponseDtos);
    }
}
