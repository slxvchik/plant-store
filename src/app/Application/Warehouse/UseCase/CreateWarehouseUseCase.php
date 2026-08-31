<?php

namespace App\Application\Warehouse\UseCase;

use App\Application\Warehouse\Dto\Request\CreateWarehouseRequestDto;

interface CreateWarehouseUseCase
{
    public function execute(CreateWarehouseRequestDto $createWarehouseRequestDto): string;
}