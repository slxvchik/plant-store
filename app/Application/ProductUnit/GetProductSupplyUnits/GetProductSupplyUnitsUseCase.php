<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\GetProductSupplyUnits;

use App\Application\ProductUnit\Shared\Dto\Response\ProductUnitResponseDto;

interface GetProductSupplyUnitsUseCase
{
    /**
     * @return ProductUnitResponseDto[]
     */
    public function execute(string $supplyId): array;
}
