<?php

declare(strict_types=1);

namespace App\Domain\Product\Model;

use DateTimeImmutable;

/**
 * Value object for save Offers in the Product
 */
readonly class SaveOffer
{
    /**
     * @param Stock[] $stocks
     */
    public function __construct(
        public ?string $id,
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
}
