<?php

declare(strict_types=1);

namespace App\Application\Product\UseCase;

use App\Application\Product\Dto\Response\ProductResponseDto;

interface GetProductByAliasUseCase
{
    public function execute(string $alias): ProductResponseDto;
}
