<?php

declare(strict_types=1);

namespace App\Application\Order\GetUserOrders;

use App\Application\Order\GetUserOrders\Dto\GetUserOrdersResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetUserOrdersUseCase
{
    /**
     * @return Page<GetUserOrdersResponseDto>
     */
    public function execute(string $userId, Pageable $pageable): Page;
}
