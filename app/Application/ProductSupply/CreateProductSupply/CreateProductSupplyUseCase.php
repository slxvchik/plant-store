<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\CreateProductSupply;

use App\Domain\Shared\Contracts\Transactional;

interface CreateProductSupplyUseCase
{
    /**
     * @param CreateProductSupplyRequestDto $requestDto
     * @return string
     */
    #[Transactional]
    public function execute(CreateProductSupplyRequestDto $requestDto): string;
}
