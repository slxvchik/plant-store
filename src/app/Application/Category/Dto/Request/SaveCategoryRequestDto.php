<?php

declare(strict_types=1);

namespace App\Application\Category\Dto\Request;

readonly class SaveCategoryRequestDto
{
    public function __construct(
        public ?string $id,
        public string $alias,
        public string $name,
        public bool $active
    ) {}
}
