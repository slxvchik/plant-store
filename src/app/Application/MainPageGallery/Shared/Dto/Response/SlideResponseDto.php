<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\Shared\Dto\Response;

use App\Application\Media\Shared\Dto\Response\ImageResponseDto;
use App\Domain\MainPageGallery\Model\MainPageGallery;
use JsonSerializable;
use Override;

readonly class SlideResponseDto implements JsonSerializable
{
    public function __construct(
        public string $id,
        public int $sort,
        public ?ImageResponseDto $image,
        public ?string $preTitle,
        public ?string $title,
        public ?string $description,
        public ?string $buttonLink,
        public ?string $buttonText,
    ) {}

    public static function fromDomain(MainPageGallery $slide, ImageResponseDto $imageResponseDto): self
    {
        return new self(
            id: $slide->id->value,
            sort: $slide->sort,
            image: $imageResponseDto,
            preTitle: $slide->preTitle,
            title: $slide->title,
            description: $slide->description,
            buttonLink: $slide->buttonLink,
            buttonText: $slide->buttonText,
        );
    }

    /**
     * @return array{id: string, sort: int, imageId: string, preTitle: ?string, title: ?string, description: ?string, buttonLink: ?string, buttonText: ?string}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'sort' => $this->sort,
            'image' => $this->image,
            'preTitle' => $this->preTitle,
            'title' => $this->title,
            'description' => $this->description,
            'buttonLink' => $this->buttonLink,
            'buttonText' => $this->buttonText,
        ];
    }
}
