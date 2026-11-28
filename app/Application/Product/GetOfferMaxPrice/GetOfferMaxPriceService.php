<?php

namespace App\Application\Product\GetOfferMaxPrice;

use App\Domain\Product\Repository\ProductRepository;

readonly class GetOfferMaxPriceService implements GetOfferMaxPriceUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {}

    public function execute(): ?int
    {
        return $this->productRepository->getMaxOfferPrice();
    }
}
