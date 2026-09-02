<?php

declare(strict_types=1);

namespace App\Domain\Product\Criteria;

use DateTimeImmutable;

final readonly class ProductSearchCriteria
{
    /**
     * @param string[] $tagIds
     */
    public function __construct(
        public ?string $name = null,
        public ?string $categoryId = null,
        public array $tagIds = [],
        public ?string $sku = null,
        public ?string $formFactor = null,
        public ?string $size = null,
        public ?int $age = null,
        public ?int $minPrice = null,
        public ?int $maxPrice = null,
        public ?DateTimeImmutable $sowingDateFrom = null,
        public ?DateTimeImmutable $sowingDateTo = null,
        public ?bool $active = true,
    ) {}
}
