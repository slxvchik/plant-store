<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\CreateProductSupply;

readonly class CreateProductSupplyRequestDto
{
    public function __construct(
        public string $supplierId,
        public ?string $offerId,
        public string $warehouseId,
        public string $initialProductUnitStatusId,
        public int $declaredQuantity,
        public int $actualQuantity,
        public ?int $unitPurchasePriceInKopecks,
        public ?int $totalPurchasePriceInKopecks,
        public string $comment,
        public bool $misGraded,
    ) {}
}
