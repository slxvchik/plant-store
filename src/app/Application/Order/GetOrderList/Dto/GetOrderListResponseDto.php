<?php

declare(strict_types=1);

namespace App\Application\Order\GetOrderList\Dto;

use App\Application\Order\GetOrderList\Dto\GetOrderListOrderLineResponseDto;
use App\Domain\Order\Model\OrderStatus;

final readonly class GetOrderListResponseDto
{
    /**
     * @param GetOrderListOrderLineResponseDto[] $orderLineResponseDto
     */
    public function __construct(
        public string $id,
        public string $userId,
        public OrderStatus $status,
        public array $orderLineResponseDto,
        public int $orderSumInKopecks,
        public GetOrderListUserResponseDto $user
    ) {}
}
