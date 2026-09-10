<?php

declare(strict_types=1);

namespace App\Application\Product\GetProductPage;

use App\Application\Product\Shared\Dto\Response\ProductResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetProductPageUseCase
{
    /**
     * @return Page<ProductResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
