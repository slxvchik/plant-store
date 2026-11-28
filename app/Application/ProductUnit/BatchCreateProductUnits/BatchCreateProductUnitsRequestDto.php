<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\BatchCreateProductUnits;

use DateTimeImmutable;

readonly class BatchCreateProductUnitsRequestDto
{
    public function __construct(
        public int $quantity,
        public string $offerId,
        public string $warehouseId,
        public string $productUnitStatusId,
        public ?string $productSupplyId,
        public ?DateTimeImmutable $sowingDate,
        public string $comments,
    ) {}
}
