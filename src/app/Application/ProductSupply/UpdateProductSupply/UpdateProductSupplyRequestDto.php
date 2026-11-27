<?php

declare(strict_types=1);

namespace App\Application\ProductSupply\UpdateProductSupply;

readonly class UpdateProductSupplyRequestDto
{
    public function __construct(
        public string $id,
        public string $supplierId,
        public ?string $offerId,
        public int $declaredQuantity,
        public int $actualQuantity,
        public ?int $unitPurchasePriceInKopecks,
        public ?int $totalPurchasePriceInKopecks,
        public string $comment,
        public bool $misGraded,
    ) {}
}
