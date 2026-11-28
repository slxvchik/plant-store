<?php

declare(strict_types=1);

namespace App\Application\Category\UpdateCategory;

interface UpdateCategoryUseCase
{
    public function execute(UpdateCategoryRequestDto $updateCategoryRequestDto): void;
}
