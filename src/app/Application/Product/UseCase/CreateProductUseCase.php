<?php

declare(strict_types=1);

namespace App\Application\Product\UseCase;

use App\Application\Product\Dto\Request\CreateProductRequestDto;

interface CreateProductUseCase
{
    public function execute(CreateProductRequestDto $createProductRequestDto): string;
}
