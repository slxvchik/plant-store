<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Dto\Request;

use App\Domain\Shared\SortedItem\SortedItem;
use DateTimeImmutable;

readonly class SaveOfferRequestDto
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
