<?php

declare(strict_types=1);

namespace App\Application\Order\TakeOrderIntoWork;

interface TakeOrderIntoWork
{
    public function execute(string $orderId): void;
}
