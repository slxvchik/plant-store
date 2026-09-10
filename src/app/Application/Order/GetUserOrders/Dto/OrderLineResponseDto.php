<?php

declare(strict_types=1);

namespace App\Application\Order\GetUserOrders\Dto;

readonly class OrderLineResponseDto
{
    public function __construct(
        public string $productOfferId,
        public int $quantity,
        public int $unitPriceInKopecks
    ) {}
}
