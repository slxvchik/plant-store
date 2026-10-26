<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Dto\Response;

use App\Application\Category\Shared\Dto\Response\CategoryResponseDto;
use App\Application\Media\Shared\Dto\Response\ImageResponseDto;
use App\Application\Media\Shared\Dto\Response\VideoResponseDto;
use App\Application\Tag\Shared\Dto\Response\TagResponseDto;
use App\Domain\Product\Model\Product;
use JsonSerializable;
use Override;

readonly class ProductResponseDto implements JsonSerializable
{
    /**
     * @param  OfferResponseDto[]  $offers
     * @param  CategoryResponseDto[]  $categories
     * @param  TagResponseDto[]  $tags
     * @param  VideoResponseDto[]  $videos
     * @param  ImageResponseDto[]  $images
     */
    public function __construct(
        public string $id,
        public bool $active,
        public string $alias,
        public string $name,
        public int $sort,
        public ?string $description,
        public array $offers,
        public array $categories,
        public array $tags,
        public array $videos,
        public array $images,
    ) {}

    /**
     * @param  OfferResponseDto[]  $offers
     * @param  CategoryResponseDto[]  $categories
     * @param  TagResponseDto[]  $tags
     * @param  VideoResponseDto[]  $videos
     * @param  ImageResponseDto[]  $images
     */
    public static function fromDomain(
        Product $product,
        array $offers,
        array $categories,
        array $tags,
        array $videos,
        array $images,
    ): self {
        return new self(
            id: $product->id->value,
            active: $product->active,
            alias: $product->alias,
            name: $product->name,
            sort: $product->sort,
            description: $product->description,
            offers: $offers,
            categories: $categories,
            tags: $tags,
            videos: $videos,
            images: $images,
        );
    }

    /**
     * @return array{id: string, active: bool, alias: string, name: string, sort: int, description: ?string, offers: OfferResponseDto[], categories: CategoryResponseDto[], tags: TagResponseDto[], videos: VideoResponseDto[], images: ImageResponseDto[]}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'active' => $this->active,
            'alias' => $this->alias,
            'name' => $this->name,
            'sort' => $this->sort,
            'description' => $this->description,
            'offers' => $this->offers,
            'categories' => $this->categories,
            'tags' => $this->tags,
            'videos' => $this->videos,
            'images' => $this->images,
        ];
    }
}
