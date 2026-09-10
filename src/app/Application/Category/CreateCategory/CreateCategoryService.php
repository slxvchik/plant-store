<?php

declare(strict_types=1);

namespace App\Application\Category\CreateCategory;

use App\Application\Category\Shared\Exception\CategoryAliasExistsException;
use App\Domain\Category\Model\Category;
use App\Domain\Category\Repository\CategoryRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Override;

class CreateCategoryService implements CreateCategoryUseCase
{
    public function __construct(
        private final UuidGeneratorInterface $uuidGeneratorInterface,
        private final CategoryRepository $categoryRepository
    ) {}

    #[Override]
    public function execute(CreateCategoryRequestDto $createCategoryRequestDto): string
    {
        $tag = $this->categoryRepository->findByAlias($createCategoryRequestDto->alias);
        if ($tag !== null) {
            throw new CategoryAliasExistsException($createCategoryRequestDto->alias);
        }

        $category = Category::createNew(
            uuidIdentityGenerator: $this->uuidGeneratorInterface,
            alias: $createCategoryRequestDto->alias,
            name: $createCategoryRequestDto->name,
            active: $createCategoryRequestDto->active
        );

        return $this->categoryRepository->create($category);
    }
}
