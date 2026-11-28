<?php

declare(strict_types=1);

namespace App\Application\Product\CreateProduct;

interface CreateProductUseCase
{
    public function execute(CreateProductRequestDto $createProductRequestDto): string;
}
