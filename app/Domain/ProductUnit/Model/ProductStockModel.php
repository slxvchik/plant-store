<?php

declare(strict_types=1);

namespace App\Domain\ProductUnit\Model;

use App\Domain\Product\Exception\ProductQuantityRemoveReserveException;
use App\Domain\Product\Exception\ProductQuantityReserveException;
use App\Domain\Product\Exception\ProductShipReserveException;

class ProductStockModel
{
    public function __construct(
        public private(set) string $warehouseId,
        public private(set) int $quantity,
        public private(set) int $reserved,
    ) {}

    public function reserve(int $quantity): self
    {
        if ($quantity > $this->quantity - $this->reserved) {
            throw new ProductQuantityReserveException;
        }

        return new self($this->warehouseId, $this->quantity, $this->reserved + $quantity);
    }

    public function cancelReserve(int $quantity): self
    {
        if ($quantity > $this->reserved) {
            throw new ProductQuantityRemoveReserveException;
        }

        return new self($this->warehouseId, $this->quantity, $this->reserved - $quantity);
    }

    public function ship(int $quantity): self
    {
        if ($quantity > $this->reserved) {
            throw new ProductShipReserveException;
        }

        return new self($this->warehouseId, $this->quantity - $quantity, $this->reserved - $quantity);
    }

    public function refund(int $quantity): self
    {
        return new self($this->warehouseId, $this->quantity + $quantity, $this->reserved);
    }
}
