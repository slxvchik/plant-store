<?php

declare(strict_types=1);

namespace App\Application\Order\GetOrderList\Dto;

final readonly class GetOrderListUserResponseDto
{
    public function __construct(
        public string $id,
        public string $firstName,
        public ?string $lastName,
        public string $email,
        public string $phone,
    ) {}
}
