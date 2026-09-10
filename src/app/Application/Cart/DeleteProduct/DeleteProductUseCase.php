<?php

namespace App\Application\Cart\DeleteProduct;

interface DeleteProductUseCase
{
    public function execute(string $id): void;
}
