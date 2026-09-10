<?php

declare(strict_types=1);

namespace App\Application\Product\GetProductByAlias;

use App\Application\Product\Shared\Dto\Response\ProductResponseDto;
use App\Application\Product\Shared\Exception\ProductNotFoundException;
use App\Application\Product\Shared\Port\ProductDetailsFetcher;
use App\Domain\Product\Repository\ProductRepository;
use Override;

readonly class GetProductByAliasService implements GetProductByAliasUseCase
{
    public function __construct(
        private ProductRepository $productRepository,
        private ProductDetailsFetcher $productDetailsFetcher
    ) {}

    #[Override]
    public function execute(string $alias): ProductResponseDto
    {
        $product = $this->productRepository->findByAlias($alias);
        if ($product === null) {
            throw new ProductNotFoundException();
        }

        $productDtoList = $this->productDetailsFetcher->getByIds([$product->id]);
        return $productDtoList[0];
    }
}
