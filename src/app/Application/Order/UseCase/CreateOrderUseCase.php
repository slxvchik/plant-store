<?php

namespace App\Application\Order\UseCase;

interface CreateOrderUseCase
{
    public function execute(string $cartId): void;
}
