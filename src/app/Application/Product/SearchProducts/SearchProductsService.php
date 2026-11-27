<?php

namespace App\Application\Product\SearchProducts;

use App\Application\Product\Shared\Port\ProductDetailsFetcher;
use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

readonly class SearchProductsService implements SearchProductsUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductDetailsFetcher $productDetailsFetcher,
    ) {}

    public function execute(ProductSearchCriteria $criteria, Pageable $pageable): Page
    {
        $searchedProductsPage = $this->productRepository->search($criteria, $pageable);

        return $searchedProductsPage->changeItems(
            newItems: $this->productDetailsFetcher->execute(
                products: $searchedProductsPage->items,
            ),
        );
    }
}
