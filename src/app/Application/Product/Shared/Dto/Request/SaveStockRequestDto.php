<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Dto\Request;

readonly class SaveStockRequestDto
{
    public function __construct(
        public string $warehouseId,
        public int $quantity,
        public int $reserved
    ) {}
}
