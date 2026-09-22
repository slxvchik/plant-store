<?php

declare(strict_types=1);

namespace App\Application\Cart\GetUserCart\Dto\Response;

readonly class GetUserCartResponseDto
{
    /**
     * @param GetUserCartCartLineResponseDto[] $cartLines
     */
    public function __construct(
        public string $cartId,
        public ?string $userId,
        public array $cartLines
    ) {}
}
