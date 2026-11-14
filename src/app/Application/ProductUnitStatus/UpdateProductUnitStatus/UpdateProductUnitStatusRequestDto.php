<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\UpdateProductUnitStatus;

readonly class UpdateProductUnitStatusRequestDto
{
    public function __construct(public string $id, public string $name, public ?string $comment) {}
}
