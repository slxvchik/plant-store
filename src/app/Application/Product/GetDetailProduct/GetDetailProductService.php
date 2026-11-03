<?php

declare(strict_types=1);

namespace App\Application\Product\GetDetailProduct;

use App\Application\Product\Shared\Dto\Response\ProductResponseDto;
use App\Application\Product\Shared\Exception\ProductNotFoundException;
use App\Application\Product\Shared\Port\ProductDetailsFetcher;
use App\Domain\Product\Repository\ProductRepository;
use Override;

readonly class GetDetailProductService implements GetDetailProductUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductDetailsFetcher $productDetailsFetcher
    ) {}

    /**
     * @throws ProductNotFoundException
     */
    #[Override]
    public function execute(GetDetailProductRequestDto $detailProductRequestDto): ProductResponseDto
    {
        $product = null;
        if ($detailProductRequestDto->id !== null) {
            $product = $this->productRepository->findById($detailProductRequestDto->id);
        } else if ($detailProductRequestDto->alias !== null) {
            $product = $this->productRepository->findByAlias($detailProductRequestDto->alias);
        }

        if ($product === null) {
            throw new ProductNotFoundException;
        }

        $productDtoList = $this->productDetailsFetcher->execute([$product]);

        return $productDtoList[0];
    }
}
