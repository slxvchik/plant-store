<?php

namespace App\Application\Product\GetFeaturedProducts;

use App\Application\Product\Shared\Port\ProductDetailsFetcher;
use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Pagination\Pageable;
use Override;

readonly class GetFeaturedProductsService implements GetFeaturedProductsUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductDetailsFetcher $productDetailsFetcher,
    ) {}

    #[Override]
    public function execute(): array
    {
        $featuredProducts = $this->productRepository->search(
            criteria: new ProductSearchCriteria(
                active: true,
                featured: true,
            ),
            pageable: new Pageable(
                page: 1,
                perPage: 30,
            ),
        );

        return $this->productDetailsFetcher->execute($featuredProducts->items);
    }
}
