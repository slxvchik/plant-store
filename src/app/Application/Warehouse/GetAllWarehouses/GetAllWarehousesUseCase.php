<?php

declare(strict_types=1);

namespace App\Application\Warehouse\GetAllWarehouses;

use App\Application\Warehouse\Shared\Dto\Response\WarehouseResponseDto;

interface GetAllWarehousesUseCase
{
    /**
     * @return WarehouseResponseDto[]
     */
    public function execute(): array;
}
