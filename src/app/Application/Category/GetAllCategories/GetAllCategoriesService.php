<?php

declare(strict_types=1);

namespace App\Application\Category\GetAllCategories;

use App\Application\Category\Shared\Dto\Response\CategoryResponseDto;
use App\Domain\Category\Repository\CategoryRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
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

        $categoryResponseDtos = [];
        foreach ($allCategories as $category) {
            $categoryResponseDtos[] = CategoryResponseDto::fromDomain($category);
        }

        return $categoryResponseDtos;
    }
}
