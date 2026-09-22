<?php

declare(strict_types=1);

namespace App\Application\Cart\GetUserCart\Dto\Response;

use App\Application\Media\Shared\Dto\Response\ImageResponseDto;
use App\Domain\Product\Model\Offer;
use App\Domain\Product\Model\Product;
use DateTimeImmutable;

readonly class GetUserCartProductResponseDto
{
    /**
     * @param array<ImageResponseDto> $images
     */
    public function __construct(
        // product info
        public string $productId,
        public string $alias,
        public string $name,
        public array $images,

        // offer info
        public string $offerId,
        public bool $active,
        public string $sku,
        public int $price,
        public ?string $formFactor,
        public ?string $size,
        public ?int $age,
        public ?DateTimeImmutable $sowingDate
    ) {}

    /**
     * @param array<ImageResponseDto> $images
     */
    public static function fromDomain(Product $product, Offer $offer, array $images): self
    {
        return new self(
            productId: $product->id->value,
            alias: $product->alias,
            name: $product->name,
            images: $images,
            offerId: $offer->id->value,
            active: $offer->active,
            sku: $offer->sku,
            price: $offer->price,
            formFactor: $offer->formFactor,
            size: $offer->size,
            age: $offer->age,
            sowingDate: $offer->sowingDate
        );
    }
}
