<?php

declare(strict_types=1);

namespace App\Application\Product\GetDetailProduct;

use App\Application\Product\Shared\Dto\Response\ProductResponseDto;

interface GetDetailProductUseCase
{
    public function execute(string $alias): ProductResponseDto;
}
