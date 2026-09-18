<?php

namespace App\Application\Order\CreateOrder;

interface CreateOrderUseCase
{
    public function execute(string $userId, int $expectedSumInKopecks): void;
}
