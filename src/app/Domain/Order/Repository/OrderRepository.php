<?php

declare(strict_types=1);

namespace App\Domain\Order\Repository;

use App\Domain\Order\Criteria\OrderSearchCriteria;
use App\Domain\Order\Model\Order;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface OrderRepository
{
    public function create(Order $order): string;

    public function update(Order $order): void;

    public function delete(string $id): void;

    public function findById(string $id): ?Order;

    /**
     * @return Order[]
     */
    public function findByUserId(string $userId): array;

    /**
     * @return Page<Order>
     */
    public function search(Pageable $pageable, OrderSearchCriteria $orderSearchCriteria): Page;
}
