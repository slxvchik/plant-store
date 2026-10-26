<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Dto\Response;

use App\Domain\Product\Model\Offer;
use DateTimeImmutable;
use JsonSerializable;
use Override;

readonly class OfferResponseDto implements JsonSerializable
{
    /**
     * @param  StockResponseDto[]  $stocks
     */
    public function __construct(
        public string $id,
        public bool $active,
        public string $sku,
        public int $sort,
        public ?string $description,
        public int $price,
        public array $stocks,
        public ?string $formFactor,
        public ?string $size,
        public ?int $age,
        public ?DateTimeImmutable $sowingDate,
    ) {}

    /**
     * @param  StockResponseDto[]  $stockResponseDtos
     */
    public static function fromDomain(Offer $offer, array $stockResponseDtos): self
    {
        return new self(
            id: $offer->id->value,
            active: $offer->active,
            sku: $offer->sku,
            sort: $offer->sort,
            description: $offer->description,
            price: $offer->price,
            stocks: $stockResponseDtos,
            formFactor: $offer->formFactor,
            size: $offer->size,
            age: $offer->age,
            sowingDate: $offer->sowingDate,
        );
    }

    /**
     * @return array{id: string, active: bool, sku: string, sort: int, description: ?string, price: int, stocks: StockResponseDto[], formFactor: ?string, size: ?string, age: ?int, sowingDate: ?string}
     */
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
            'stocks' => $this->stocks,
            'formFactor' => $this->formFactor,
            'size' => $this->size,
            'age' => $this->age,
            'sowingDate' => $this->sowingDate?->format('Y-m-d'),
        ];
    }
}
