<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\GetAllProductSupplies;

use App\Application\ProductSupply\Shared\Dto\Response\ProductSupplyResponseDto;

interface GetAllProductSuppliesUseCase
{
    /**
     * @return ProductSupplyResponseDto[]
     */
    public function execute(): array;
}
