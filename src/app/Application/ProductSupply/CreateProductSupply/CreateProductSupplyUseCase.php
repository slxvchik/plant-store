<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\CreateProductSupply;

interface CreateProductSupplyUseCase
{
    public function execute(CreateProductSupplyRequestDto $requestDto): string;
}
