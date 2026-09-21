<?php

namespace App\Application\Cart\SaveProduct;

readonly class SaveProductRequestDto
{
    public function __construct(
        public string $cartId,
        public string $productId,
        public string $offerId,
        public int $quantity
    ) {}
}
