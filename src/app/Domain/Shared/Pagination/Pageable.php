<?php

declare(strict_types=1);

namespace App\Domain\Shared\Pagination;

final readonly class Pageable
{
    public function __construct(
        public int $page,
        public int $perPage
    ) {}
}
