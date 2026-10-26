<?php

declare(strict_types=1);

namespace App\Application\Category\UpdateCategory;

use App\Application\Category\Shared\Exception\CategoryAliasExistsException;
use App\Application\Category\Shared\Exception\CategoryNotFoundException;
use App\Domain\Category\Repository\CategoryRepository;
use App\Domain\Shared\Exception\InternalException;
use Override;

readonly class UpdateCategoryService implements UpdateCategoryUseCase
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {}

    /**
     * @throws InternalException
     * @throws CategoryNotFoundException
     * @throws CategoryAliasExistsException
     */
    #[Override]
    public function execute(UpdateCategoryRequestDto $updateCategoryRequestDto): void
    {
        $category = $this->categoryRepository->findById($updateCategoryRequestDto->id);
        if ($category === null) {
            throw new CategoryNotFoundException;
        }

        if ($updateCategoryRequestDto->parentId !== null) {
            $parentCategory = $this->categoryRepository->findById($updateCategoryRequestDto->parentId);
            if ($parentCategory === null) {
                throw new CategoryNotFoundException($updateCategoryRequestDto->parentId);
            }
        }

        $category->update(
            parentId: $updateCategoryRequestDto->parentId,
            alias: $updateCategoryRequestDto->alias,
            sort: $updateCategoryRequestDto->sort,
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
