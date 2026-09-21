<?php

declare(strict_types=1);

namespace App\Application\Order\GetOrders;

use App\Application\Order\GetOrders\Dto\GetOrdersResponseDto;
use App\Domain\Order\Criteria\OrderSearchCriteria;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetOrdersUseCase
{
    /**
     * @return Page<GetOrdersResponseDto>
     */
    public function execute(Pageable $pageable, OrderSearchCriteria $orderSearchCriteria): Page;
}
