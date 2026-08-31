<?php

declare(strict_types=1);

namespace App\Application\Product\Dto\Request;

readonly class SaveStockRequestDto
{
    public function __construct(
        public string $warehouseId,
        public int $quantity,
        public int $reserved
    ) {}
}
