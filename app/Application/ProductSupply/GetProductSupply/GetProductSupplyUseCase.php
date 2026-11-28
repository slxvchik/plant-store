<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\GetProductSupply;

use App\Application\ProductSupply\Shared\Dto\Response\ProductSupplyResponseDto;

interface GetProductSupplyUseCase
{
    public function execute(string $id): ProductSupplyResponseDto;
}
