<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\BatchCreateProductUnits;

use App\Domain\Shared\Contracts\Transactional;

interface BatchCreateProductUnitsUseCase
{
    /**
     * @return string[]
     */
    #[Transactional]
    public function execute(BatchCreateProductUnitsRequestDto $requestDto): array;
}
