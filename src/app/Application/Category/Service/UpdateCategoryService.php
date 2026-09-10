<?php

declare(strict_types=1);

namespace App\Application\Category\Service;

use App\Application\Category\Exception\CategoryAliasExistsException;
use App\Application\Category\Exception\CategoryNotFoundException;
use App\Application\Category\Dto\Request\UpdateCategoryRequestDto;
use App\Application\Category\UseCase\UpdateCategoryUseCase;
use App\Domain\Category\Repository\CategoryRepository;
use Override;

class UpdateCategoryService implements UpdateCategoryUseCase
{
    public function __construct(
        private final CategoryRepository $categoryRepository
    ) {}

    #[Override]
    public function execute(UpdateCategoryRequestDto $updateCategoryRequestDto): void
    {
        $category = $this->categoryRepository->findById($updateCategoryRequestDto->id);
        if ($category === null) {
            throw new CategoryNotFoundException();
        }

        $category->update(
            alias: $updateCategoryRequestDto->alias,
            name: $updateCategoryRequestDto->name,
            active: $updateCategoryRequestDto->active
        );

        $existingCategory = $this->categoryRepository->findByAlias($category->alias);

        if ($existingCategory !== null && $existingCategory->id->value !== $category->id->value) {
            throw new CategoryAliasExistsException($category->alias);
        }

        $this->categoryRepository->update($category);
    }
}
