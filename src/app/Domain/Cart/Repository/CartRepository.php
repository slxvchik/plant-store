<?php

declare(strict_types=1);

namespace App\Domain\Cart\Repository;

use App\Domain\Cart\Model\Cart;
use App\Domain\Shared\BaseRepository\BaseRepository;

/**
 * @extends BaseRepository<Cart>
 */
interface CartRepository extends BaseRepository
{
    public function findByUserId(string $userId): ?Cart;
}
