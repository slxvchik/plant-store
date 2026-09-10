<?php

declare(strict_types=1);

namespace App\Application\Product\UseCase;

use App\Application\Product\Dto\Request\UpdateProductRequestDto;

interface UpdateProductUseCase
{
    public function execute(UpdateProductRequestDto $saveProductRequestDto): void;
}
