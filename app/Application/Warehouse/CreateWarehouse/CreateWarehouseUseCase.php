<?php

namespace App\Application\Warehouse\CreateWarehouse;

interface CreateWarehouseUseCase
{
    public function execute(CreateWarehouseRequestDto $createWarehouseRequestDto): string;
}
