<?php

declare(strict_types=1);

namespace App\Application\Category\CreateCategory;

interface CreateCategoryUseCase
{
    public function execute(CreateCategoryRequestDto $createCategoryRequestDto): string;
}
