<?php

namespace App\Application\Warehouse\Dto\Request;

readonly class CreateWarehouseRequestDto
{
    public function __construct(
        public string $address,
        public ?string $phoneNumber
    ) {}
} 