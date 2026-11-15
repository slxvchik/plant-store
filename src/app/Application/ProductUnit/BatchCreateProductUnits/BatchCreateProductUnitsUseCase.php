<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\BatchCreateProductUnits;

interface BatchCreateProductUnitsUseCase
{
    /**
     * @return string[]
     */
    public function execute(BatchCreateProductUnitsRequestDto $requestDto): array;
}
