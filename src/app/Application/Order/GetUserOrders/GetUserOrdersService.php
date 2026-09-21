<?php

namespace App\Application\Order\GetUserOrders;

use App\Domain\Order\Repository\OrderRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

final readonly class GetUserOrdersService implements GetUserOrdersUseCase
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    public function execute(string $userId, Pageable $pageable): Page
    {
        // TODO: Implement execute() method.
    }
}
