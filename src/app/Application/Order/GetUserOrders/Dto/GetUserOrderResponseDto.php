<?php

declare(strict_types=1);

namespace App\Application\Order\Dto\Response;

use App\Domain\Order\Model\OrderStatus;

readonly class GetUserOrderResponseDto
{
    /**
     * @param OrderLineResponseDto[] $orderLineResponseDto
     */
    public function __construct(
        public string $id,
        public string $userId,
        public OrderStatus $status,
        public array $orderLineResponseDto,
        public int $orderSumInKopecks
    ) {}
}
