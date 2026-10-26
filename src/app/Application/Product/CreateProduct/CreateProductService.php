<?php

declare(strict_types=1);

namespace App\Application\Product\CreateProduct;

use App\Application\Product\Shared\Exception\ProductAliasExistsException;
use App\Application\Product\Shared\Mapper\SaveOfferMapper;
use App\Domain\Product\Model\Product;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Override;

readonly class CreateProductService implements CreateProductUseCase
{
    public function __construct(
        private UuidGeneratorInterface $uuidGeneratorInterface,
        private ProductRepository $productRepository,
    ) {}

    /**
     * @throws ProductAliasExistsException
     */
    #[Override]
    public function execute(CreateProductRequestDto $createProductRequestDto): string
    {
        $product = Product::createNew(
            uuidIdentityGenerator: $this->uuidGeneratorInterface,
            active: $createProductRequestDto->active,
            alias: $createProductRequestDto->alias,
            sort: $createProductRequestDto->sort,
            name: $createProductRequestDto->name,
            categories: $createProductRequestDto->categoryIds,
            tags: $createProductRequestDto->tagIds,
            videoIds: $createProductRequestDto->videoIds,
            imageIds: $createProductRequestDto->imageIds,
            description: $createProductRequestDto->description,
        );

        if ($this->productRepository->findByAlias($product->alias) !== null) {
            throw new ProductAliasExistsException($product->alias);
        }

        $product->saveOffers(
            SaveOfferMapper::fromDtos($createProductRequestDto->offers),
            $this->uuidGeneratorInterface,
        );

        return $this->productRepository->create($product);
    }
}
