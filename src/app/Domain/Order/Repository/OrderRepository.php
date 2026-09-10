<?php

declare(strict_types=1);

namespace App\Domain\Order\Repository;

use App\Domain\Order\Criteria\OrderSearchCriteria;
use App\Domain\Order\Model\Order;
use App\Domain\Shared\BaseRepository\BaseRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

/**
 * @extends BaseRepository<Order>
 */
interface OrderRepository extends BaseRepository
{
    /**
     * @return Order[] 
     */
    public function findByUserId(string $userId): array;

    /**
     * @return Page<Order>
     */
    public function search(Pageable $pageable, OrderSearchCriteria $orderSearchCriteria): Page;
}
