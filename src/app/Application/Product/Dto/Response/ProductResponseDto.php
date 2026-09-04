<?php

declare(strict_types=1);

namespace App\Application\Product\Dto\Response;

use App\Application\Category\Dto\Response\CategoryResponseDto;
use App\Application\Media\Dto\Request\VideoResponseDto;
use App\Application\Media\Dto\Response\ImageResponseDto;
use App\Application\Tag\Dto\Response\TagResponseDto;
use App\Domain\Product\Models\Product;

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

    /**
     * @param OfferResponseDto[] $offers
     * @param CategoryResponseDto[] $categories
     * @param TagResponseDto[] $tags
     * @param VideoResponseDto[] $videos
     * @param ImageResponseDto[] $images
     */
    public static function fromDomain(
        Product $product,
        array $offers,
        array $categories,
        array $tags,
        array $videos,
        array $images
    ): self {
        return new self(
            id: $product->id->value,
            active: $product->active,
            alias: $product->alias,
            name: $product->name,
            description: $product->description,
            offers: $offers,
            categories: $categories,
            tags: $tags,
            videos: $videos,
            images: $images
        );
    }
}
