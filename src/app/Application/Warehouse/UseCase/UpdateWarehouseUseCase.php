<?php

namespace App\Application\Warehouse\UseCase;

use App\Application\Warehouse\Dto\Request\UpdateWarehouseRequestDto;

interface UpdateWarehouseUseCase
{
    public function execute(UpdateWarehouseRequestDto $updateWarehouseRequestDto): void;
}
