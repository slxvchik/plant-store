<?php

declare(strict_types=1);

namespace App\Application\Product\UseCase;

use App\Application\Product\Dto\Response\ProductResponseDto;

interface GetProductByAlias
{
    public function execute(string $alias): ProductResponseDto;
}
