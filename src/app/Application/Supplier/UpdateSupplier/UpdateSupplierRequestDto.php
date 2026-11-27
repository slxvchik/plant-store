<?php

declare(strict_types=1);

namespace App\Application\Supplier\UpdateSupplier;

readonly class UpdateSupplierRequestDto
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $phone,
        public ?string $email,
        public ?string $address,
        public ?string $comment,
    ) {}
}
