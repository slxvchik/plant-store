<?php

declare(strict_types=1);

namespace App\Domain\Product\Model;

use App\Domain\Shared\SortedItem\SortedItem;
use DateTimeImmutable;

/**
 * Value object for save Offers in the Product
 */
readonly class SaveOffer
{
    /**
     * @param  Stock[]  $stocks
     * @param  SortedItem<string>[]  $imageIds
     * @param  SortedItem<string>[]  $videoIds
     */
    public function __construct(
        public ?string $id,
        public bool $active,
        public string $sku,
        public int $sort,
        public ?string $description,
        public int $price,
        public array $stocks,
        public ?string $formFactor,
        public ?string $size,
        public ?int $age,
        public ?DateTimeImmutable $sowingDate,
        public array $imageIds,
        public array $videoIds
    ) {}
}
