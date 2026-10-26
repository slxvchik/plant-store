<?php

declare(strict_types=1);

namespace App\Http\Requests\Warehouse;

use App\Application\Warehouse\UpdateWarehouse\UpdateWarehouseRequestDto;

class UpdateWarehouseRequest extends WarehouseRequest
{
    public function toDto(string $id): UpdateWarehouseRequestDto
    {
        return new UpdateWarehouseRequestDto(...['id' => $id, ...$this->warehouseData()]);
    }
}
