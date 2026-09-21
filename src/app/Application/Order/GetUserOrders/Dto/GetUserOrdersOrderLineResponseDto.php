<?php

declare(strict_types=1);

namespace App\Application\Order\GetUserOrders\Dto;

use App\Application\Media\Shared\Dto\Response\ImageResponseDto;

final readonly class GetUserOrdersOrderLineResponseDto
{
    public function __construct(
        public string $productId,
        public string $productOfferId,
        public string $productName,
        public ?ImageResponseDto $productImage,
        public int $quantity,
        public int $unitPriceInKopecks
    ) {}
}
