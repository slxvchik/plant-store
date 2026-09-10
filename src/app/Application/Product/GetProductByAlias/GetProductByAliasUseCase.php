<?php

declare(strict_types=1);

namespace App\Application\Product\GetProductByAlias;

use App\Application\Product\Shared\Dto\Response\ProductResponseDto;

interface GetProductByAliasUseCase
{
    public function execute(string $alias): ProductResponseDto;
}
