<?php

declare(strict_types=1);

namespace App\Domain\Shared\Pagination;

final readonly class Pageable
{
    public int $page;

    public int $perPage;

    public function __construct(
        ?int $page = 1,
        ?int $perPage = 10,
        private int $maxPerPage = 100,
    ) {
        $this->page = max($page ?? 1, 1);
        $this->perPage = min(max($perPage ?? 10, 1), $this->maxPerPage);
    }
}
