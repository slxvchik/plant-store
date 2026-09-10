<?php

namespace App\Application\Warehouse\UpdateWarehouse;

interface UpdateWarehouseUseCase
{
    public function execute(UpdateWarehouseRequestDto $updateWarehouseRequestDto): void;
}
