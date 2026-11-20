<?php

declare(strict_types=1);

namespace App\Application\Product\GetProductOptions;

use App\Application\Product\Shared\Dto\Response\ProductOptionResponseDto;

/**
 * This use case is needed to display all products in the select inputs.
 */
interface GetProductOptionsUseCase
{
    /**
     * @return ProductOptionResponseDto[]
     */
    public function execute(): array;
}
