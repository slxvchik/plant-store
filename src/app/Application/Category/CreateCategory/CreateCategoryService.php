<?php

declare(strict_types=1);

namespace App\Application\Category\CreateCategory;

use App\Application\Category\Shared\Exception\CategoryAliasExistsException;
use App\Application\Category\Shared\Exception\CategoryNotFoundException;
use App\Domain\Category\Model\Category;
use App\Domain\Category\Repository\CategoryRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Override;

readonly class CreateCategoryService implements CreateCategoryUseCase
{
    public function __construct(
        private UuidGeneratorInterface $uuidGeneratorInterface,
        private CategoryRepository $categoryRepository
    ) {}

    /**
     * @throws CategoryAliasExistsException
     * @throws CategoryNotFoundException
     */
    #[Override]
    public function execute(CreateCategoryRequestDto $createCategoryRequestDto): string
    {
        $categoryExists = $this->categoryRepository->findByAlias($createCategoryRequestDto->alias);
        if ($categoryExists !== null) {
            throw new CategoryAliasExistsException($createCategoryRequestDto->alias);
        }

        if ($createCategoryRequestDto->parentId !== null) {
            $parentCategory = $this->categoryRepository->findById($createCategoryRequestDto->parentId);
            if ($parentCategory === null) {
                throw new CategoryNotFoundException($createCategoryRequestDto->parentId);
            }
        }

        $category = Category::createNew(
            uuidIdentityGenerator: $this->uuidGeneratorInterface,
            parentId: $createCategoryRequestDto->parentId,
            alias: $createCategoryRequestDto->alias,
            sort: $createCategoryRequestDto->sort,
            name: $createCategoryRequestDto->name,
            active: $createCategoryRequestDto->active
        );

        return $this->categoryRepository->create($category);
    }
}
