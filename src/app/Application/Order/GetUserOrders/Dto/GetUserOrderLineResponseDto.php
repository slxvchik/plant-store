<?php

declare(strict_types=1);

namespace App\Application\Order\GetUserOrders\Dto;

readonly class GetUserOrderLineResponseDto
{
    public function __construct(
        public string $productId,
        public string $productOfferId,
        public string $productName,
        public int $quantity,
        public int $unitPriceInKopecks
    ) {}
}
