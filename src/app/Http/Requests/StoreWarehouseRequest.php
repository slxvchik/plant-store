<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Application\Warehouse\CreateWarehouse\CreateWarehouseRequestDto;

class StoreWarehouseRequest extends WarehouseRequest
{
    public function toDto(): CreateWarehouseRequestDto
    {
        return new CreateWarehouseRequestDto(...$this->warehouseData());
    }
}
