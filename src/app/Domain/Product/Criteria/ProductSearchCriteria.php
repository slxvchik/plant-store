<?php

declare(strict_types=1);

namespace App\Domain\Product\Criteria;

final readonly class ProductSearchCriteria
{
    /**
     * @param  string[]  $categoryAliases
     * @param  string[]  $tagAliases
     */
    public function __construct(
        public ?string $name = null,
        public array $categoryAliases = [],
        public array $tagAliases = [],
        public ?string $sku = null,
        public ?int $minPrice = null,
        public ?int $maxPrice = null,
        public ?bool $active = true,
        public ?bool $featured = null,
        public ?bool $inStock = null,
        public ProductSort $sort = ProductSort::SORT,
    ) {}
}
