<?php

declare(strict_types=1);

namespace App\Application\Category\Service;

use App\Application\Category\Exception\CategoryNotFoundException;
use App\Application\Category\UseCase\DeleteCategoryUseCase;
use App\Domain\Category\Repository\CategoryRepository;
use Override;

class DeleteCategoryService implements DeleteCategoryUseCase
{
    public function __construct(
        private final CategoryRepository $categoryRepository
    ) {}

    #[Override]
    public function execute(string $id): void
    {
        $category = $this->categoryRepository->findById($id);
        if ($category === null) {
            throw new CategoryNotFoundException();
        }

        $this->categoryRepository->delete($id);
    }
}
