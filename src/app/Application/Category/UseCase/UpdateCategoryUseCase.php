<?php

declare(strict_types=1);

namespace App\Application\Category\UseCase;

use App\Application\Category\Dto\Request\UpdateCategoryRequestDto;

interface UpdateCategoryUseCase
{
    public function execute(UpdateCategoryRequestDto $updateCategoryRequestDto): void;
}
