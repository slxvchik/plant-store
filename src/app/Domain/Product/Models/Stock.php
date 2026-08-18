<?php

declare(strict_types=1);

namespace App\Domain\Product\Models;

use App\Domain\Product\Exceptions\ProductFastSellQuantityException;
use App\Domain\Product\Exceptions\ProductQuantityRemoveReserveException;
use App\Domain\Product\Exceptions\ProductQuantityReserveException;
use App\Domain\Product\Exceptions\ProductShipReserveException;

/**
 * Value object
 */
readonly class Stock
{
    public function __construct(
        public string $warehouseId,
        public int    $quantity,
        public int    $reserved
    ) {}

    public function getAvailableQuantity(): int
    {
        return $this->quantity - $this->reserved;
    }

    public function reserve(int $quantity): self
    {
        $stockQuantity = $this->quantity - $quantity;
        if ($stockQuantity < 0) {
            throw new ProductQuantityReserveException();
        }

        return new self(
            $this->warehouseId,
            $stockQuantity,
            $this->reserved + $quantity
        );
    }

    public function cancelReserve(int $quantity): self
    {
        $reserved = $this->reserved - $quantity;
        if ($reserved < 0) {
            throw new ProductQuantityRemoveReserveException();
        }

        return new self(
            $this->warehouseId,
            $this->quantity + $reserved,
            $reserved
        );
    }

    public function ship(int $quantity): self
    {
        $reservedQuantity = $this->reserved - $quantity;
        if ($reservedQuantity < 0) {
            throw new ProductShipReserveException();
        }

        return new self(
            $this->warehouseId,
            $this->quantity,
            $reservedQuantity
        );
    }

    public function refund(int $quantity): self
    {
        return new self(
            $this->warehouseId,
            $this->quantity + $quantity,
            $this->reserved
        );
    }

    public function fastSell(int $quantity): self
    {
        $stockQuantity = $this->quantity - $quantity;
        if ($stockQuantity < 0) {
            throw new ProductFastSellQuantityException();
        }
        return new self(
            $this->warehouseId,
            $stockQuantity,
            $this->reserved
        );
    }
}
