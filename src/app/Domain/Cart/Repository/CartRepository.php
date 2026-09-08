<?php

declare(strict_types=1);

namespace App\Domain\Cart\Repository;

use App\Domain\Cart\Model\Cart;

interface CartRepository
{
    public function findByUserId(string $userId): Cart;

    public function save(Cart $cart): void;
}
