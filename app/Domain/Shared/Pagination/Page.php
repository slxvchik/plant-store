<?php

declare(strict_types=1);

namespace App\Domain\Shared\Pagination;

/**
 * @template T
 */
final readonly class Page
{
    /**
     * @param  T[]  $items
     */
    public function __construct(
        public array $items,
        public int $pageNumber,
        public int $pageSize,
        public int $totalPages,
        public int $totalCount,
        public bool $hasPrev,
        public bool $hasNext,
    ) {}

    /**
     * @return self<never>
     */
    public static function empty(): self
    {
        return new self(
            items: [],
            pageNumber: 1,
            pageSize: 10,
            totalPages: 1,
            totalCount: 0,
            hasPrev: false,
            hasNext: false,
        );
    }

    /**
     * @template U
     *
     * @param  U[]  $newItems
     * @return Page<U>
     */
    public function changeItems(array $newItems): Page
    {
        return new Page(
            items: $newItems,
            pageNumber: $this->pageNumber,
            pageSize: $this->pageSize,
            totalPages: $this->totalPages,
            totalCount: $this->totalCount,
            hasPrev: $this->hasPrev,
            hasNext: $this->hasNext,
        );
    }
}
