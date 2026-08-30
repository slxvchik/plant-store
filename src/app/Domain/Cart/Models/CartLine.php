<?php

declare(strict_types=1);

namespace App\Domain\Cart\Models;

/**
 * Value object
 */
readonly class CartLine
{
    public int $quantity;
    public function __construct(
        public string $productSkuId,
        int $quantity
    ) {
        $this->quantity = $quantity > 0 ? $quantity : 1;
    }

    public function changeQuantity(int $quantity): self
    {
        if ($quantity <= 0) {
            $quantity = 1;
        }
        return new CartLine(
            productSkuId: $this->productSkuId,
            quantity: $quantity
        );
    }
}