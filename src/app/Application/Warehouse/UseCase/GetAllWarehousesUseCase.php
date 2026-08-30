<?php

declare(strict_types=1);

namespace App\Application\Warehouse\UseCase;

use App\Application\Warehouse\Dto\Response\WarehouseResponseDto;

interface GetAllWarehousesUseCase
{
    /**
     * @return WarehouseResponseDto[]
     */
    public function execute(): array;
}