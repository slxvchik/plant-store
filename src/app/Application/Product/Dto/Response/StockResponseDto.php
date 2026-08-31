<?php

declare(strict_types=1);

namespace App\Application\Product\Dto\Response;

use App\Application\Warehouse\Dto\Response\WarehouseResponseDto;

readonly class StockResponseDto
{
    public function __construct(
        public WarehouseResponseDto $warehouseResponseDto,
        public int $quantity,
        public int $reserved
    ) {}
}
