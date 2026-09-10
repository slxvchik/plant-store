<?php

declare(strict_types=1);

namespace App\Application\Order\GetOrderList;

use App\Application\Order\GetOrderList\Dto\GetOrderListResponseDto;
use App\Domain\Order\Criteria\OrderSearchCriteria;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetOrderListUseCase
{
    /**
     * @return Page<GetOrderListResponseDto>
     */
    public function execute(Pageable $pageable, OrderSearchCriteria $orderSearchCriteria): Page;
}
