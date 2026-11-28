<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\UpdateProductSupply;

interface UpdateProductSupplyUseCase
{
    public function execute(UpdateProductSupplyRequestDto $requestDto): void;
}
