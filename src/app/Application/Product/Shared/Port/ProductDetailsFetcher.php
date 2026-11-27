<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Port;

use App\Application\Product\Shared\Dto\Response\ProductResponseDto;
use App\Domain\Product\Model\ProductModel;

interface ProductDetailsFetcher
{
    /**
     * @param  ProductModel[]  $products
     * @return ProductResponseDto[]
     */
    public function execute(array $products): array;
}
