<?php

declare(strict_types=1);

namespace App\Application\Product\Service;

use App\Application\Product\Dto\Response\ProductResponseDto;
use App\Application\Product\Exception\ProductNotFoundException;
use App\Application\Product\Port\ProductDetailsFetcher;
use App\Application\Product\UseCase\GetProductByAliasUseCase;
use App\Domain\Product\Repository\ProductRepository;
use Override;

class GetProductByAliasService implements GetProductByAliasUseCase
{
    public function __construct(
        private final ProductRepository $productRepository,
        private final ProductDetailsFetcher $productDetailsFetcher
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
