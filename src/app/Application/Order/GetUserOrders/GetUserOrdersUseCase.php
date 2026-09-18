<?php

declare(strict_types=1);

namespace App\Application\Order\GetUserOrders;

use App\Application\Order\Dto\Response\GetUserOrderResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetUserOrdersUseCase
{
    /**
     * @return Page<GetUserOrderResponseDto>
     */
    public function execute(string $userId, Pageable $pageable): Page;
}
