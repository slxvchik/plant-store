<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\UpdateProductUnitStatus;

interface UpdateProductUnitStatusUseCase
{
    public function execute(UpdateProductUnitStatusRequestDto $requestDto): void;
}
