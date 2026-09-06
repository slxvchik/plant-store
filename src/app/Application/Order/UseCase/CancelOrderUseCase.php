<?php

namespace App\Application\Order\UseCase;

interface CancelOrderUseCase
{
    public function execute(string $cartId): void;
}
