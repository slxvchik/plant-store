<?php

declare(strict_types=1);

namespace App\Application\Product\Dto\Response;

use App\Application\Warehouse\Dto\Response\WarehouseResponseDto;
use App\Domain\Product\Models\Stock;

readonly class StockResponseDto
{
    public function __construct(
        public WarehouseResponseDto $warehouseResponseDto,
        public int $quantity,
        public int $reserved
    ) {}

    public static function fromDomain(Stock $stock, WarehouseResponseDto $warehouseResponseDto): self
    {
        return new self(
            warehouseResponseDto: $warehouseResponseDto,
            quantity: $stock->quantity,
            reserved: $stock->reserved
        );
    }
}
