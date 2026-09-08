<?php

namespace App\Application\Warehouse\Dto\Request;

readonly class UpdateWarehouseRequestDto
{
    public function __construct(
        public string $id,
        public string $address,
        public ?string $phoneNumber
    ) {}
}
