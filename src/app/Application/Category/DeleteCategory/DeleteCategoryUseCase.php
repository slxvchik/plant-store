<?php

declare(strict_types=1);

namespace App\Application\Category\DeleteCategory;

interface DeleteCategoryUseCase
{
    public function execute(string $id): void;
}
