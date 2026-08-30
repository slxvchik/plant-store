<?php

namespace App\Application\Warehouse\Dto\Request;

readonly class UpdateWarehouseDto
{
    public function __construct(
        public string $address,
        public ?string $phoneNumber
    ) {}
} 