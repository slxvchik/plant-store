<?php

namespace App\Application\Cart\SaveProduct;

use App\Application\Cart\SaveProduct\Dto\SaveProductRequestDto;
use App\Application\Cart\SaveProduct\Dto\SaveProductResponseDto;

interface SaveProductUseCase
{
    public function execute(SaveProductRequestDto $saveProductRequestDto): SaveProductResponseDto;
}
