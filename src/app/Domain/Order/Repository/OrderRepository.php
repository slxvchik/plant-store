<?php

declare(strict_types=1);

namespace App\Domain\Order\Repository;

use App\Domain\Order\Model\Order;
use App\Domain\Shared\BaseRepository\BaseRepository;

/**
 * @extends BaseRepository<Order>
 */
interface OrderRepository extends BaseRepository
{
    /**
     * @return Order[] 
     */
    function findByUserId(string $userId): array;
}
