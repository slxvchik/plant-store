<?php

declare(strict_types=1);

namespace App\Application\Product\UpdateProduct;

use App\Application\Product\Shared\Dto\Request\SaveOfferRequestDto;

readonly class UpdateProductRequestDto
{
    /**
     * @param string[] $categoryIds
     * @param string[] $tagIds
     * @param string[] $videoIds
     * @param string[] $imageIds
     * @param SaveOfferRequestDto[] $offers
     */
    public function __construct(
        public string $id,
        public bool $active,
        public string $alias,
        public string $name,
        public ?string $description,
        public array $categoryIds,
        public array $tagIds,
        public array $videoIds,
        public array $imageIds,
        public array $offers
    ) {}
}
