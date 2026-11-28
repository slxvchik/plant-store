<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\GetProductUnitStatuses;

use App\Application\ProductUnitStatus\Shared\Dto\Response\ProductUnitStatusResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetProductUnitStatusesUseCase
{
    /**
     * @return Page<ProductUnitStatusResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
