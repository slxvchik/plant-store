<?php

declare(strict_types=1);

namespace App\Application\Category\GetCategoriesPage;

use App\Application\Category\Shared\Dto\Response\CategoryResponseDto;
use App\Domain\Category\Repository\CategoryRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use Override;

readonly class GetCategoriesPageService implements GetCategoriesPageUseCase
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        $page = $this->categoryRepository->findPage($pageable);

        $parentIds = [];
        foreach ($page->items as $category) {
            if ($category->parentId !== null) {
                $parentIds[$category->parentId->value] = true;
            }
        }

        $parentsMap = [];
        if (! empty($parentIds)) {
            $parents = $this->categoryRepository->findByIds(array_keys($parentIds));
            foreach ($parents as $parent) {
                $parentsMap[$parent->id->value] = $parent;
            }
        }

        $categoryResponseDtos = [];
        foreach ($page->items as $category) {
            $categoryResponseDtos[] = CategoryResponseDto::fromDomain(
                category: $category,
                parent: $category->parentId?->value ? $parentsMap[$category->parentId->value] : null,
            );
        }

        return $page->changeItems($categoryResponseDtos);
    }
}
