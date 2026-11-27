<?php

declare(strict_types=1);

namespace App\Domain\ProductUnit;

final readonly class ProductUnitCriteria
{
    public function __construct(
        public ?string $offerId = null,
        public ?string $warehouseId = null,
        public ?string $productUnitStatusId = null,
        public ?string $productSupplyId = null,
    ) {}
}
