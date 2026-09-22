<?php

declare(strict_types=1);

namespace App\Application\Cart\GetUserCart\Dto\Response;

readonly class GetUserCartCartLineResponseDto
{
    public function __construct(
        public GetUserCartProductResponseDto $product,
        // stock info
        public int $quantity,
        public int $availableQuantity
    ) {}
}
