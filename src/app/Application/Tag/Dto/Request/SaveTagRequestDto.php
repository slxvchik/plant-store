<?php

declare(strict_types=1);

namespace App\Application\Tag\Dto\Request;

readonly class SaveTagRequestDto
{
    public function __construct(
        public ?string $id,
        public string $alias,
        public string $name,
        public bool $active,
    ) {}
}
