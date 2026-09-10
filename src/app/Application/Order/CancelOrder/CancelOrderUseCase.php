<?php

namespace App\Application\Order\CancelOrder;

interface CancelOrderUseCase
{
    public function execute(string $cartId): void;
}
