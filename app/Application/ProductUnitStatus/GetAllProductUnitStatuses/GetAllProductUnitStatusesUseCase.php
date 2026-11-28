<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\GetAllProductUnitStatuses;

use App\Application\ProductUnitStatus\Shared\Dto\Response\ProductUnitStatusResponseDto;

interface GetAllProductUnitStatusesUseCase
{
    /**
     * @return ProductUnitStatusResponseDto[]
     */
    public function execute(): array;
}
