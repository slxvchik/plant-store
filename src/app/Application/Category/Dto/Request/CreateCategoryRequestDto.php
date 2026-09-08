<?php

declare(strict_types=1);

namespace App\Application\Category\Dto\Request;

readonly class CreateCategoryRequestDto
{
    public function __construct(
        public string $alias,
        public string $name,
        public bool $active
    ) {}
}
