<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\UpdateProductUnit;

interface UpdateProductUnitUseCase
{
    public function execute(UpdateProductUnitRequestDto $requestDto): void;
}
