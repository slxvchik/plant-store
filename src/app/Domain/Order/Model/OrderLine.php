<?php

declare(strict_types=1);

namespace App\Domain\Order\Model;

/**
 * Value object
 */
class OrderLine
{
    private(set) final string $productOfferId;
    private(set) final int $quantity;
    private(set) final int $unitPriceInKopecks;

    public function __construct(string $productOfferId, int $quantity, int $unitPriceInKopecks)
    {
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
