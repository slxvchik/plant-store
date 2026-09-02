<?php

declare(strict_types=1);

namespace App\Domain\Cart\Repositories;

use App\Domain\Cart\Models\Cart;

interface CartRepository
{
    public function findByUserId(string $userId): Cart;

    public function save(Cart $cart): void;
}
