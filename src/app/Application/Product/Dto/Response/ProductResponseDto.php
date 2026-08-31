<?php

declare(strict_types=1);

namespace App\Application\Product\Dto\Response;

/**
 * @property OfferResponseDto[] $offers
 * @property CategoryResponseDto[] $categories
 * @property TagResponseDto[] $tags
 * @property VideoResponseDto[] $videos
 * @property ImageResponseDto[] $images
 */
readonly class ProductResponseDto
{
    /**
     * @param OfferResponseDto[] $offers
     * @param CategoryResponseDto[] $categories
     * @param TagResponseDto[] $tags
     * @param VideoResponseDto[] $videos
     * @param ImageResponseDto[] $images
     */
    public function __construct(
        public string $id,
        public bool $active,
        public string $alias,
        public string $name,
        public ?string $description,
        public array $offers,
        public array $categories,
        public array $tags,
        public array $videos,
        public array $images
    ) {}
}
