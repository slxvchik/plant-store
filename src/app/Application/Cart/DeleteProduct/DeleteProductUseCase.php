<?php

namespace App\Application\Cart\DeleteProduct;

interface DeleteProductUseCase
{
    public function execute(DeleteProductRequestDto $deleteProductRequestDto): void;
}
