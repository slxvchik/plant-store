<?php

declare(strict_types=1);

namespace App\Application\Product\UseCase;

use App\Domain\Product\Model\Product;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetProductPageUseCase
{
    /**
     * @return Page<Product>
     */
    public function execute(Pageable $pageable): Page;
}
