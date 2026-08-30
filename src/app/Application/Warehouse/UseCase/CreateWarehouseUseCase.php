<?php

namespace App\Application\Warehouse\UseCase;

use App\Application\Warehouse\Dto\Request\CreateWarehouseDto;

interface CreateWarehouseUseCase
{
    public function execute(CreateWarehouseDto $createWarehouseDto): string;
}