<?php

declare(strict_types=1);

namespace App\Domain\Order\Model;

/**
 * Value object
 */
class OrderLine
{
    final public private(set) string $productId;

    final public private(set) string $productOfferId;

    final public private(set) int $quantity;

    final public private(set) int $unitPriceInKopecks;

    public function __construct(string $productId, string $productOfferId, int $quantity, int $unitPriceInKopecks)
    {
        $this->productId = $productId;
        $this->productOfferId = $productOfferId;
        $this->quantity = $quantity;
        $this->unitPriceInKopecks = $unitPriceInKopecks;
    }

    /**
     * @return int price in kopecks
     */
    public function getTotalPrice(): int
    {
        return $this->unitPriceInKopecks * $this->quantity;
    }
}
