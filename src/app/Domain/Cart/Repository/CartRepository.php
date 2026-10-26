<?php

declare(strict_types=1);

namespace App\Domain\Cart\Repository;

use App\Domain\Cart\Model\Cart;

interface CartRepository
{
    public function create(Cart $cart): string;

    public function update(Cart $cart): void;

    public function findById(string $id): ?Cart;

    public function findByUserId(string $userId): ?Cart;
}
