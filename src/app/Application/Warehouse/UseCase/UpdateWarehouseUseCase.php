<?php

namespace App\Application\Warehouse\UseCase;

use App\Application\Warehouse\Dto\Request\UpdateWarehouseDto;

interface UpdateWarehouseUseCase
{
    public function execute(UpdateWarehouseDto $updateWarehouseDto): void;
}