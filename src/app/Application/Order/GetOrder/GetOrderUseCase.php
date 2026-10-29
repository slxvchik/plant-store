<?php

declare(strict_types=1);

namespace App\Application\Order\GetOrder;

use App\Application\Order\GetOrders\Dto\GetOrdersResponseDto;
use App\Application\Order\Shared\Exception\OrderNotFoundException;

interface GetOrderUseCase
{
    /**
     * @throws OrderNotFoundException
     */
    public function execute(string $id): GetOrdersResponseDto;
}
