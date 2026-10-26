<?php

declare(strict_types=1);

namespace App\Application\Product\UpdateProduct;

use App\Application\Product\Shared\Exception\ProductAliasExistsException;
use App\Application\Product\Shared\Exception\ProductNotFoundException;
use App\Application\Product\Shared\Mapper\SaveOfferMapper;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Override;

readonly class UpdateProductService implements UpdateProductUseCase
{
    public function __construct(
        private UuidGeneratorInterface $uuidGeneratorInterface,
        private ProductRepository $productRepository,
    ) {}

    /**
     * @throws ProductAliasExistsException
     * @throws ProductNotFoundException
     */
    #[Override]
    public function execute(UpdateProductRequestDto $updateProductRequestDto): void
    {
        $product = $this->productRepository->findById($updateProductRequestDto->id);

        if ($product === null) {
            throw new ProductNotFoundException;
        }

        $product->update(
            alias: $updateProductRequestDto->alias,
            sort: $updateProductRequestDto->sort,
            name: $updateProductRequestDto->name,
            active: $updateProductRequestDto->active,
            description: $updateProductRequestDto->description,
            categoryIds: $updateProductRequestDto->categoryIds,
            tagIds: $updateProductRequestDto->tagIds,
            videoIds: $updateProductRequestDto->videoIds,
            imageIds: $updateProductRequestDto->imageIds,
        );

        $existingProduct = $this->productRepository->findByAlias($product->alias);

        if ($existingProduct !== null && $existingProduct->id->value !== $product->id->value) {
            throw new ProductAliasExistsException($product->alias);
        }

        $product->saveOffers(
            SaveOfferMapper::fromDtos($updateProductRequestDto->offers),
            $this->uuidGeneratorInterface,
        );

        $this->productRepository->update($product);
    }
}
