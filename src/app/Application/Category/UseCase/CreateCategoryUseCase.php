<?php

declare(strict_types=1);

namespace App\Application\Category\UseCase;

use App\Application\Category\Dto\Request\CreateCategoryRequestDto;

interface CreateCategoryUseCase
{
    public function execute(CreateCategoryRequestDto $createCategoryRequestDto): string;
}
