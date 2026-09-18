<?php

namespace App\Application\Order\CancelOrder;

interface CancelOrderUseCase
{
    public function execute(string $orderId): void;
}
