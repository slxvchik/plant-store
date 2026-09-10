<?php

declare(strict_types=1);

namespace App\Application\Product\Service;

use App\Application\Product\Dto\Request\CreateProductRequestDto;
use App\Application\Product\Dto\Request\SaveOfferRequestDto;
use App\Application\Product\Dto\Request\SaveStockRequestDto;
use App\Application\Product\Exception\ProductAliasExistsException;
use App\Application\Product\UseCase\CreateProductUseCase;
use App\Domain\Product\Model\Product;
use App\Domain\Product\Model\SaveOffer;
use App\Domain\Product\Model\Stock;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Override;

class CreateProductService implements CreateProductUseCase
{
    public function __construct(
        private final UuidGeneratorInterface $uuidGeneratorInterface,
        private final ProductRepository $productRepository,
    ) {}

    #[Override]
    public function execute(CreateProductRequestDto $createProductRequestDto): string
    {
        $product = Product::createNew(
            uuidIdentityGenerator: $this->uuidGeneratorInterface,
            active: $createProductRequestDto->active,
            alias: $createProductRequestDto->alias,
            name: $createProductRequestDto->name,
            categories: $createProductRequestDto->categoryIds,
            tags: $createProductRequestDto->tagIds,
            videoIds: $createProductRequestDto->videoIds,
            imageIds: $createProductRequestDto->imageIds,
            description: $createProductRequestDto->description
        );

        $existingProduct = $this->productRepository->findByAlias($product->alias);
        if ($existingProduct !== null) {
            throw new ProductAliasExistsException($product->alias);
        }

        $newOffers = $this->buildOffers($createProductRequestDto->offers);

        $product->saveOffers($newOffers, $this->uuidGeneratorInterface);

        return $this->productRepository->create($product);
    }

    /**
     * @param SaveOfferRequestDto[] $saveOfferRequestDtos
     * @return SaveOffer[]
     */
    private function buildOffers(array $saveOfferRequestDtos): array
    {
        $newOffers = [];
        foreach ($saveOfferRequestDtos as $saveOffer) {
            $stocks = $this->buildStocks($saveOffer->stocks);
            $newOffers[] = new SaveOffer(
                id: null,
                active: $saveOffer->active,
                sku: $saveOffer->sku,
                description: $saveOffer->description,
                price: $saveOffer->price,
                stocks: $stocks,
                formFactor: $saveOffer->formFactor,
                size: $saveOffer->size,
                age: $saveOffer->age,
                sowingDate: $saveOffer->sowingDate
            );
        }
        return $newOffers;
    }

    /**
     * @param SaveStockRequestDto[] $saveStockRequestDtos
     * @return Stock[]
     */
    private function buildStocks(array $saveStockRequestDtos): array
    {
        $stocks = [];
        foreach ($saveStockRequestDtos as $saveStockRequestDto) {
            $stocks[] = new Stock(
                warehouseId: $saveStockRequestDto->warehouseId,
                quantity: $saveStockRequestDto->quantity,
                reserved: $saveStockRequestDto->reserved
            );
        }
        return $stocks;
    }
}
