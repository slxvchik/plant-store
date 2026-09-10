<?php

declare(strict_types=1);

namespace App\Application\Product\Service;

use App\Application\Product\Port\ProductDetailsFetcher;
use App\Application\Product\UseCase\GetProductPageUseCase;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Shared\Pagination\Page;
use Override;

class GetProductPageService implements GetProductPageUseCase
{
    public function __construct(
        private final ProductRepository $productRepository,
        private final ProductDetailsFetcher $productDetailsFetcher
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
