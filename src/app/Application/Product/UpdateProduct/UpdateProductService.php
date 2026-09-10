<?php

declare(strict_types=1);

namespace App\Application\Product\UpdateProduct;

use App\Application\Product\Shared\Dto\Request\SaveOfferRequestDto;
use App\Application\Product\Shared\Dto\Request\SaveStockRequestDto;
use App\Application\Product\Shared\Exception\ProductAliasExistsException;
use App\Application\Product\Shared\Exception\ProductNotFoundException;
use App\Domain\Product\Model\SaveOffer;
use App\Domain\Product\Model\Stock;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Override;

readonly class UpdateProductService implements UpdateProductUseCase
{
    public function __construct(
        private UuidGeneratorInterface $uuidGeneratorInterface,
        private ProductRepository $productRepository
    ) {}

    #[Override]
    public function execute(UpdateProductRequestDto $updateProductRequestDto): void
    {
        $product = $this->productRepository->findById($updateProductRequestDto->id);
        if ($product === null) {
            throw new ProductNotFoundException();
        }

        $product->update(
            alias: $updateProductRequestDto->alias,
            name: $updateProductRequestDto->name,
            active: $updateProductRequestDto->active,
            description: $updateProductRequestDto->description,
            categoryIds: $updateProductRequestDto->categoryIds,
            tagIds: $updateProductRequestDto->tagIds,
            videoIds: $updateProductRequestDto->videoIds,
            imageIds: $updateProductRequestDto->imageIds
        );

        $existingProduct = $this->productRepository->findByAlias($product->alias);
        if ($existingProduct !== null && $existingProduct->id->value !== $product->id->value) {
            throw new ProductAliasExistsException($product->alias);
        }

        $offers = $this->buildOffers($updateProductRequestDto->offers);

        $product->saveOffers($offers, $this->uuidGeneratorInterface);

        $this->productRepository->update($product);
    }

    /**
     * @param SaveOfferRequestDto[] $offerDtos
     * @return SaveOffer[]
     */
    private function buildOffers(array $offerDtos): array
    {
        $offers = [];

        foreach ($offerDtos as $offerDto) {
            $stocks = $this->buildStocks($offerDto->stocks);

            $offers[] = new SaveOffer(
                id: $offerDto->id,
                active: $offerDto->active,
                sku: $offerDto->sku,
                description: $offerDto->description,
                price: $offerDto->price,
                stocks: $stocks,
                formFactor: $offerDto->formFactor,
                size: $offerDto->size,
                age: $offerDto->age,
                sowingDate: $offerDto->sowingDate
            );
        }

        return $offers;
    }

    /**
     * @param SaveStockRequestDto[] $stockDtos
     * @return Stock[]
     */
    private function buildStocks(array $stockDtos): array
    {
        $stocks = [];

        foreach ($stockDtos as $stockDto) {
            $stocks[] = new Stock(
                warehouseId: $stockDto->warehouseId,
                quantity: $stockDto->quantity,
                reserved: $stockDto->reserved
            );
        }

        return $stocks;
    }
}
