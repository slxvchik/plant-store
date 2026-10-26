<?php

namespace App\Repositories;

use App\Domain\Media\Model\Image as DomainImageModel;
use App\Domain\Media\Repository\ImageRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Models\Image;
use Override;

class ImageRepositoryImpl implements ImageRepository
{
    /**
     * @param  DomainImageModel  $entity
     */
    #[Override]
    public function create(object $entity): string
    {
        $image = Image::create([
            'id' => $entity->id->value,
            'mime_type' => $entity->mimeType,
            'size_in_bytes' => $entity->sizeInBytes,
            'width' => $entity->width,
            'height' => $entity->height,
            'title_text' => $entity->titleText,
            'alt_text' => $entity->altText,
        ]);

        return $image->id;
    }

    /**
     * @param  DomainImageModel  $entity
     */
    #[Override]
    public function update(object $entity): void
    {
        Image::where('id', $entity->id->value)->update([
            'title_text' => $entity->titleText,
            'alt_text' => $entity->altText,
        ]);
    }

    #[Override]
    public function delete(string $id): void
    {
        Image::destroy($id);
    }

    #[Override]
    public function findById(int|string $id): ?object
    {
        $image = Image::find($id);

        return $image->exists() ? $image->toDomain() : null;
    }

    #[Override]
    public function findByIds(array $ids): array
    {
        // TODO: Implement findByIds() method.
    }

    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        // TODO: Implement findPage() method.
    }

    #[Override]
    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }
}
