<?php

declare(strict_types=1);

namespace App\Domain\Cart\Model;

/**
 * Value object
 */
readonly class CartLine
{
    public int $quantity;
    public function __construct(
        public string $productId,
        public string $offerId,
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
            productId: $this->productId,
            offerId: $this->offerId,
            quantity: $quantity
        );
    }
}
