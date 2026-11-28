<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\GetProductUnits;

use App\Application\ProductUnit\Shared\Dto\Response\ProductUnitResponseDto;
use App\Domain\ProductUnit\ProductUnitCriteria;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetProductUnitsUseCase
{
    /**
     * @return Page<ProductUnitResponseDto>
     */
    public function execute(Pageable $pageable, ?ProductUnitCriteria $criteria = null): Page;
}
