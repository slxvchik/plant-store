<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Dto\Response;

use App\Application\Media\Shared\Dto\Response\ImageResponseDto;
use App\Domain\Product\Model\OfferModel;
use DateTimeImmutable;
use JsonSerializable;
use Override;

readonly class OfferResponseDto implements JsonSerializable
{
    /**
    * @param  ImageResponseDto[]  $images
     */
    public function __construct(
        public string $id,
        public bool $active,
        public string $sku,
        public ?string $name,
        public int $sort,
        public ?string $description,
        public int $price,
        public int $stockQuantity,
        public array $images,
    ) {}

    /**
    * @param  ImageResponseDto[]  $images
     */
    public static function fromDomain(
        OfferModel $offer,
        array $images,
    ): self {
        return new self(
            id: $offer->id->value,
            active: $offer->active,
            sku: $offer->sku,
            name: $offer->name,
            sort: $offer->sort,
            description: $offer->description,
            price: $offer->price,
            stockQuantity: $offer->stockQuantity,
            images: $images,
        );
    }

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'active' => $this->active,
            'sku' => $this->sku,
            'name' => $this->name,
            'sort' => $this->sort,
            'description' => $this->description,
            'price' => $this->price,
            'stockQuantity' => $this->stockQuantity,
            'images' => $this->images,
        ];
    }
}
