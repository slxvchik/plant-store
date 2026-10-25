<?php

declare(strict_types=1);

namespace App\Application\Category\GetAllCategories;

use App\Application\Category\Shared\Dto\Response\CategoryResponseDto;
use App\Domain\Category\Repository\CategoryRepository;
use Override;

readonly class GetAllCategoriesService implements GetAllCategoriesUseCase
{
    public function __construct(
        final private CategoryRepository $categoryRepository
    ) {}

    #[Override]
    public function execute(): array
    {
        $allCategories = $this->categoryRepository->findAll();

        $categoriesMap = [];

        foreach ($allCategories as $category) {
            $categoriesMap[$category->id->value] = $category;
        }

        $categoryResponseDtos = [];
        foreach ($allCategories as $category) {
            $categoryResponseDtos[] = CategoryResponseDto::fromDomain(
                category: $category,
                parent: $category->parentId?->value ? $categoriesMap[$category->parentId->value] : null,
            );
        }

        return $categoryResponseDtos;
    }
}
