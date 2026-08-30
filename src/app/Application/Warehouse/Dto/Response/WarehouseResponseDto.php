<?php

declare(strict_types=1);

namespace App\Application\Warehouse\Dto\Response;

readonly class WarehouseResponseDto
{
    public function __construct(
        public string $id,
        public string $address,
        public ?string $phoneNumber
    ) {}
}