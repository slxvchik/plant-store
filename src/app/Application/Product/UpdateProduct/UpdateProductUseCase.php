<?php

declare(strict_types=1);

namespace App\Application\Product\UpdateProduct;

interface UpdateProductUseCase
{
    public function execute(UpdateProductRequestDto $updateProductRequestDto): void;
}
