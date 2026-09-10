<?php

namespace App\Application\Order\CompleteOrder;

interface CompleteOrderUseCase
{
    public function execute(string $id): void;
}
