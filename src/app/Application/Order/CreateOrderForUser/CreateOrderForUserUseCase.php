<?php

declare(strict_types=1);

namespace App\Application\Order\CreateOrderForUser;

use App\Application\Cart\Shared\Exception\CartNotFoundException;
use App\Application\Order\CreateOrder\Exception\OrderEmptyCartException;

interface CreateOrderForUserUseCase
{
    /**
     * @throws CartNotFoundException
     * @throws OrderEmptyCartException
     */
    public function execute(string $userId): void;
}
