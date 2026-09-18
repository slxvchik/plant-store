<?php

declare(strict_types=1);

namespace App\Application\Order\GetOrderList;

use App\Domain\Order\Criteria\OrderSearchCriteria;
use App\Domain\Order\Repository\OrderRepository;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Shared\Pagination\Page;
use Override;

readonly class GetOrderListService implements GetOrderListUseCase
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    #[Override]
    public function execute(Pageable $pageable, OrderSearchCriteria $orderSearchCriteria): Page
    {
        $ordersPage = $this->orderRepository->search($pageable, $orderSearchCriteria);
        
        $orderResponseDtos = [];
        
    }
}
