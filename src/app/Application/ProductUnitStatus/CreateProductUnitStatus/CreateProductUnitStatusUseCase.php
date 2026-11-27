<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\CreateProductUnitStatus;

interface CreateProductUnitStatusUseCase
{
    public function execute(CreateProductUnitStatusRequestDto $requestDto): string;
}
