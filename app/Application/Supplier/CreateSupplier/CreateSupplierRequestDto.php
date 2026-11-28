<?php

declare(strict_types=1);

namespace App\Application\Supplier\CreateSupplier;

readonly class CreateSupplierRequestDto
{
    public function __construct(
        public string $name,
        public ?string $phone,
        public ?string $email,
        public ?string $address,
        public ?string $comment,
    ) {}
}
