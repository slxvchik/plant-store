<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\GetProductUnitStatus;

use App\Application\ProductUnitStatus\Shared\Dto\Response\ProductUnitStatusResponseDto;

interface GetProductUnitStatusUseCase
{
    public function execute(string $id): ProductUnitStatusResponseDto;
}
