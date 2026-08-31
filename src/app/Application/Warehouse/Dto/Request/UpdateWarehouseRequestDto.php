<?php

namespace App\Application\Warehouse\Dto\Request;

readonly class UpdateWarehouseRequestDto
{
    public function __construct(
        public string $address,
        public ?string $phoneNumber
    ) {}
} 