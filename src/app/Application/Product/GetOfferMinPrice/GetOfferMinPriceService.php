<?php

namespace App\Application\Product\GetOfferMinPrice;

use App\Domain\Product\Repository\ProductRepository;

readonly class GetOfferMinPriceService implements GetOfferMinPriceUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {}

    public function execute(): ?int
    {
        return $this->productRepository->getMinOfferPrice();
    }
}
