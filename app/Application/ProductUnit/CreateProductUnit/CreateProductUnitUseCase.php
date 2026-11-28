<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\CreateProductUnit;

interface CreateProductUnitUseCase
{
    public function execute(CreateProductUnitRequestDto $requestDto): string;
}
