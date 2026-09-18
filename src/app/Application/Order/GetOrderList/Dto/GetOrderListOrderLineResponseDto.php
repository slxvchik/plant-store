<?php

declare(strict_types=1);

namespace App\Application\Order\GetOrderList\Dto;

readonly class GetOrderListOrderLineResponseDto
{
    public function __construct(
        public string $productId,
        public string $offerId,
        public string $name,
        public int $quantity,
        public int $unitPriceInKopecks,
        public string $warehouseAddress
    ) {}
}
