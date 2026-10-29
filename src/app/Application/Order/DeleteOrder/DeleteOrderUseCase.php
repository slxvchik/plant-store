<?php

declare(strict_types=1);

namespace App\Application\Order\DeleteOrder;

use App\Application\Order\Shared\Exception\OrderNotFoundException;

interface DeleteOrderUseCase
{
    /**
     * @throws OrderNotFoundException
     */
    public function execute(string $id): void;
}
