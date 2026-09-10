<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Port;

use App\Application\Product\Shared\Dto\Response\ProductResponseDto;

interface ProductDetailsFetcher
{
    public function getByAlias(string $alias): ?ProductResponseDto;
    /**
     * @param string[] $ids
     * @return ProductResponseDto[]
     */
    public function getByIds(array $ids): array;
}
