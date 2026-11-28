<?php

namespace App\Application\Product\SearchProducts;

use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface SearchProductsUseCase
{
    public function execute(ProductSearchCriteria $criteria, Pageable $pageable): Page;
}
