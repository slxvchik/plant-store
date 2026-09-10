<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Dto\Response;

use App\Domain\Product\Model\Offer;
use DateTimeImmutable;

/**
 * @property StockResponseDto[] $stocks
 */
readonly class OfferResponseDto
{
    /**
     * @param StockResponseDto[] $stocks
     */
    public function __construct(
        public string $id,
        public bool $active,
        public string $sku,
        public ?string $description,
        public int $price,
        public array $stocks,
        public ?string $formFactor,
        public ?string $size,
        public ?int $age,
        public ?DateTimeImmutable $sowingDate
    ) {}

    /**
     * @param StockResponseDto[] $stockResponseDto
     */
    public static function fromDomain(Offer $offer, array $stockResponseDto): self
    {
        return new self(
            id: $offer->id->value,
            active: $offer->active,
            sku: $offer->sku,
            description: $offer->description,
            price: $offer->price,
            stocks: $stockResponseDto,
            formFactor: $offer->formFactor,
            size: $offer->size,
            age: $offer->age,
            sowingDate: $offer->sowingDate
        );
    }
}
