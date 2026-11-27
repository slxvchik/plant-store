<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\CreateProductUnit;

use DateTimeImmutable;

readonly class CreateProductUnitRequestDto
{
    public function __construct(
        public ?string $productSupplyId,
        public ?string $offerId,
        public string $warehouseId,
        public bool $reserved,
        public ?DateTimeImmutable $sowingDate,
        public string $productUnitStatusId,
        public string $comments,
    ) {}
}
