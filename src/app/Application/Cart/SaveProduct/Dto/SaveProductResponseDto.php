<?php

declare(strict_types=1);

namespace App\Application\Cart\SaveProduct\Dto;

readonly class SaveProductResponseDto
{
    public function __construct(
        public string $productId,
        public string $offerId,
        public int $quantity,
        public int $availableQuantity
    ) {}
}
