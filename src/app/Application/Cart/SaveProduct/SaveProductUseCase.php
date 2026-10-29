<?php

namespace App\Application\Cart\SaveProduct;

use App\Application\Cart\SaveProduct\Dto\SaveProductRequestDto;
use App\Application\Cart\SaveProduct\Dto\SaveProductResponseDto;
use App\Application\Cart\Shared\Exception\CartNotFoundException;

interface SaveProductUseCase
{
    /**
     * @throws CartNotFoundException
     * @param SaveProductRequestDto $saveProductRequestDto
     * @return SaveProductResponseDto
     */
    public function execute(SaveProductRequestDto $saveProductRequestDto): SaveProductResponseDto;
}
