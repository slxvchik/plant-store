<?php

declare(strict_types=1);

namespace App\Application\ProductUnit\UpdateProductUnit;

use DateTimeImmutable;

readonly class UpdateProductUnitRequestDto
{
    public function __construct(
        public string $id,
        public ?string $productSupplyId,
        public ?string $offerId,
        public string $warehouseId,
        public bool $reserved,
        public ?DateTimeImmutable $sowingDate,
        public string $productUnitStatusId,
        public string $comments,
        public ?string $qrCode,
    ) {}
}
