<?php

declare(strict_types=1);

namespace App\Application\Product\DeleteProduct;

interface DeleteProductUseCase
{
    public function execute(string $id): void;
}
