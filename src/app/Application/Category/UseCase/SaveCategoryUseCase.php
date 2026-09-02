<?php

declare(strict_types=1);

namespace App\Application\Category\UseCase;

use App\Domain\Category\Models\Category;

interface SaveCategoryUseCase
{
    public function execute(Category $category): string;
}
