<?php

declare(strict_types=1);

namespace App\Domain\Product\Model;

use App\Domain\ProductUnit\Model\ProductStockModel;
use App\Domain\Shared\SortedItem\SortedItem;
use DateTimeImmutable;

/**
 * Value object for save Offers in the Product
 */
readonly class SaveOffer
{
    /**
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
        public int $stockQuantity,
        public array $imageIds,
        public array $videoIds
    ) {}
}
