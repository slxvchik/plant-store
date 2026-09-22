<?php

declare(strict_types=1);

namespace App\Application\Cart\DeleteProduct;

readonly class DeleteProductRequestDto
{
    public function __construct(
        public string $userId,
        public string $cartId,
        public string $productId,
        public string $offerId
    ) {}
}
