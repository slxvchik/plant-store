<?php

declare(strict_types=1);

namespace App\Application\Order\GetOrders\Dto;

use App\Application\Media\Shared\Dto\Response\ImageResponseDto;

final readonly class GetOrdersOrderLineResponseDto
{
    public function __construct(
        public string            $productId,
        public string            $offerId,
        public ?ImageResponseDto $imageResponseDto,
        public ?string           $productName,
        public int               $quantity,
        public int               $unitPriceInKopecks,
        public string            $warehouseAddress
    ) {}
}
