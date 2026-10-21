<?php

namespace App\Domain\MainPageGallery\Model;

use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class MainPageGallery
{
    public private(set) Uuid $id;

    public private(set) int $sort;

    public private(set) string $imageId;

    public private(set) ?string $preTitle;

    public private(set) ?string $title;

    public private(set) ?string $description;

    public private(set) ?string $buttonLink;

    public private(set) ?string $buttonText;

    private function __construct(Uuid $id, int $sort, string $imageId, ?string $preTitle, ?string $title, ?string $description, ?string $buttonLink, ?string $buttonText)
    {
        $this->id = $id;
        $this->sort = $sort;
        $this->imageId = $imageId;
        $this->preTitle = $preTitle;
        $this->title = $title;
        $this->description = $description;
        $this->buttonLink = $buttonLink;
        $this->buttonText = $buttonText;
    }

    public static function fromDb(string $id, int $sort, string $imageId, ?string $preTitle, ?string $title, ?string $description, ?string $buttonLink, ?string $buttonText): self
    {
        $uuid = new Uuid($id);

        return new self(
            id: $uuid,
            sort: $sort,
            imageId: $imageId,
            preTitle: $preTitle,
            title: $title,
            description: $description,
            buttonLink: $buttonLink,
            buttonText: $buttonText
        );
    }

    public static function createNew(UuidGeneratorInterface $uuidGeneratorInterface, int $sort, string $imageId, ?string $preTitle, ?string $title, ?string $description, ?string $buttonLink, ?string $buttonText): self
    {
        $id = $uuidGeneratorInterface->generate();
        $uuid = new Uuid($id);

        return new self(
            id: $uuid,
            sort: $sort,
            imageId: $imageId,
            preTitle: $preTitle,
            title: $title,
            description: $description,
            buttonLink: $buttonLink,
            buttonText: $buttonText
        );
    }

    public function update(int $sort, string $imageId, ?string $preTitle, ?string $title, ?string $description, ?string $buttonLink, ?string $buttonText): void
    {
        $this->sort = $sort;
        $this->imageId = $imageId;
        $this->preTitle = $preTitle;
        $this->title = $title;
        $this->description = $description;
        $this->buttonLink = $buttonLink;
        $this->buttonText = $buttonText;
    }
}
