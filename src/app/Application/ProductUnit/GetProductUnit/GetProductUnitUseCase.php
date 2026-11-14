<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\GetProductUnit;

use App\Application\ProductUnit\Shared\Dto\Response\ProductUnitResponseDto;

interface GetProductUnitUseCase
{
    public function execute(string $id): ProductUnitResponseDto;
}
