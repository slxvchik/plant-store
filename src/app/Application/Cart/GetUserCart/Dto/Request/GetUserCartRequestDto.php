<?php

declare(strict_types=1);

namespace App\Application\Cart\GetUserCart\Dto\Request;

readonly class GetUserCartRequestDto
{
    public function __construct(
        public string $cartId,
        public ?string $userId
    ) {}
}
