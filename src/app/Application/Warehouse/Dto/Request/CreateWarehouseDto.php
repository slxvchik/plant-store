<?php

namespace App\Application\Warehouse\Dto\Request;

readonly class CreateWarehouseDto
{
    public function __construct(
        public string $address,
        public ?string $phoneNumber
    ) {}
} 