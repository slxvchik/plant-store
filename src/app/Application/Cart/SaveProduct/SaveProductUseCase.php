<?php

namespace App\Application\Cart\SaveProduct;

interface SaveProductUseCase
{
    public function execute(SaveProductRequestDto $saveProductRequestDto): void;
}
