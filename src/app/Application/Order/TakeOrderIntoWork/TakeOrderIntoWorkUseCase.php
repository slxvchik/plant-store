<?php

declare(strict_types=1);

namespace App\Application\Order\TakeOrderIntoWork;

interface TakeOrderIntoWorkUseCase
{
    public function execute(string $orderId): void;
}
