<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Dto\Response;

use App\Domain\Product\Model\OfferModel;
use DateTimeImmutable;
use JsonSerializable;
use Override;

readonly class OfferResponseDto implements JsonSerializable
{
    public function __construct(
        public string $id,
        public bool $active,
        public string $sku,
        public int $sort,
        public ?string $description,
        public int $price,
        public int $stockQuantity,
    ) {}

    public static function fromDomain(OfferModel $offer): self
    {
        return new self(
            id: $offer->id->value,
            active: $offer->active,
            sku: $offer->sku,
            sort: $offer->sort,
            description: $offer->description,
            price: $offer->price,
            stockQuantity: $offer->stockQuantity,
        );
    }

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'active' => $this->active,
            'sku' => $this->sku,
            'sort' => $this->sort,
            'description' => $this->description,
            'price' => $this->price,
            'stockQuantity' => $this->stockQuantity,
        ];
    }
}
