<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\CreateProductUnitStatus;

readonly class CreateProductUnitStatusRequestDto
{
    public function __construct(public string $name, public ?string $comment) {}
}
