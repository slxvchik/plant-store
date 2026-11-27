<?php

namespace App\Application\Product\GetFeaturedProducts;

use App\Application\Product\Shared\Dto\Response\ProductResponseDto;

interface GetFeaturedProductsUseCase
{
    /**
     * @return ProductResponseDto[]
     */
    public function execute(): array;
}
