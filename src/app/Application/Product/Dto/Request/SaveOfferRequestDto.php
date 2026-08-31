<?php

declare(strict_types=1);

namespace App\Application\Product\Dto\Request;

use DateTimeImmutable;

readonly class SaveOfferRequestDto
{
    /**
     * @param SaveStockRequestDto[] $stocks
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
