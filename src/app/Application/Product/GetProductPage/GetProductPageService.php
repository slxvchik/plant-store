<?php

declare(strict_types=1);

namespace App\Application\Product\GetProductPage;

use App\Application\Product\Shared\Port\ProductDetailsFetcher;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use Override;

readonly class GetProductPageService implements GetProductPageUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductDetailsFetcher $productDetailsFetcher
    ) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        $page = $this->productRepository->findPage($pageable);

        $productIds = [];
        foreach ($page->items as $item) {
            $productIds[] = $item->id->value;
        }

        $productDtos = $this->productDetailsFetcher->getByIds($productIds);

        return $page->changeItems($productDtos);
    }
}
