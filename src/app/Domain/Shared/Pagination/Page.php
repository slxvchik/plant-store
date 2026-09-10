<?php

declare(strict_types=1);

namespace App\Domain\Shared\Pagination;

/**
 * @template T
 */
final readonly class Page
{
    /**
     * @param T[] $items
     */
    public function __construct(
        public array $items,
        public int $pageNumber,
        public int $pageSize,
        public int $totalPages,
        public int $totalCount,
        public bool $hasPrev,
        public bool $hasNext
    ) {}

    public static function empty(): self
    {
        return new self(
            items: [],
            pageNumber: 0,
            pageSize: 0,
            totalPages: 0,
            totalCount: 0,
            hasPrev: false,
            hasNext: false
        );
    }

    /**
     * @param T[] $newItems
     * @return Page<T>
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
            hasNext: $this->hasNext
        );
    }
}
