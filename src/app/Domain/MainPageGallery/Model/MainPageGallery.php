<?php

namespace App\Domain\MainPageGallery\Model;

use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;

class MainPageGallery
{
    private(set) Uuid $id;
    private(set) string $imageId;
    private(set) ?string $preTitle;
    private(set) ?string $title;
    private(set) ?string $description;
    private(set) ?string $buttonLink;
    private(set) ?string $buttonText;

    private function __construct(Uuid $id, string $imageId, ?string $preTitle, ?string $title, ?string $description, ?string $buttonLink, ?string $buttonText)
    {
        $this->id = $id;
        $this->imageId = $imageId;
        $this->preTitle = $preTitle;
        $this->title = $title;
        $this->description = $description;
        $this->buttonLink = $buttonLink;
        $this->buttonText = $buttonText;
    }

    public static function fromDb(string $id, string $imageId, ?string $preTitle, ?string $title, ?string $description, ?string $buttonLink, ?string $buttonText): self
    {
        $uuid = new Uuid($id);
        return new self(
            id: $uuid,
            imageId: $imageId,
            preTitle: $preTitle,
            title: $title,
            description: $description,
            buttonLink: $buttonLink,
            buttonText: $buttonText
        );
    }

    public static function createNew(UuidGeneratorInterface $uuidGeneratorInterface, string $imageId, ?string $preTitle, ?string $title, ?string $description, ?string $buttonLink, ?string $buttonText): self
    {
        $id = $uuidGeneratorInterface->generate();
        $uuid = new Uuid($id);
        return new self(
            id: $uuid,
            imageId: $imageId,
            preTitle: $preTitle,
            title: $title,
            description: $description,
            buttonLink: $buttonLink,
            buttonText: $buttonText
        );
    }

    public function update(string $imageId, ?string $preTitle, ?string $title, ?string $description, ?string $buttonLink, ?string $buttonText): void
    {
        $this->imageId = $imageId;
        $this->preTitle = $preTitle;
        $this->title = $title;
        $this->description = $description;
        $this->buttonLink = $buttonLink;
        $this->buttonText = $buttonText;
    }
}
