<?php

declare(strict_types=1);

namespace App\Application\Category\DeleteCategory;

use App\Application\Category\Shared\Exception\CategoryNotFoundException;
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
