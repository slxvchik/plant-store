<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\GetProductSupplies;

use App\Application\ProductSupply\Shared\Dto\Response\ProductSupplyResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetProductSuppliesUseCase
{
    /**
     * @return Page<ProductSupplyResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
