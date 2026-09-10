<?php

namespace App\Application\Warehouse\CreateWarehouse;

readonly class CreateWarehouseRequestDto
{
    public function __construct(
        public string $address,
        public ?string $phoneNumber
    ) {}
}
