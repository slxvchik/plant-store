<?php

declare(strict_types=1);

namespace App\Application\Product\CreateProduct;

use App\Application\Product\Shared\Dto\Request\SaveOfferRequestDto;
use App\Domain\Shared\SortedItem\SortedItem;

readonly class CreateProductRequestDto
{
    /**
     * @param  string[]  $tagIds
     * @param  SortedItem<string>[]  $videoIds
     * @param  SortedItem<string>[]  $imageIds
     * @param  SaveOfferRequestDto[]  $offers
     */
    public function __construct(
        public bool $active,
        public string $alias,
        public int $sort,
        public string $name,
        public ?string $description,
        public ?string $categoryId,
        public bool $featured,
        public array $tagIds,
        public array $videoIds,
        public array $imageIds,
        public array $offers
    ) {}
}
