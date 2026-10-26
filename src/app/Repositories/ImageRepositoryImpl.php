<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\Media\Model\Image as DomainImage;
use App\Domain\Media\Repository\ImageRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Models\Image;
use Override;

class ImageRepositoryImpl implements ImageRepository
{
    #[Override]
    public function create(DomainImage $image): string
    {
        $created = Image::create([
            'id' => $image->id->value,
            'mime_type' => $image->mimeType,
            'size_in_bytes' => $image->sizeInBytes,
            'width' => $image->width,
            'height' => $image->height,
            'title_text' => $image->titleText,
            'alt_text' => $image->altText,
        ]);

        return $created->id;
    }

    #[Override]
    public function update(DomainImage $image): void
    {
        Image::findOrFail($image->id->value)->update([
            'title_text' => $image->titleText,
            'alt_text' => $image->altText,
        ]);
    }

    #[Override]
    public function delete(string $id): void
    {
        Image::findOrFail($id)->delete();
    }

    #[Override]
    public function findById(string $id): ?DomainImage
    {
        return Image::find($id)?->toDomain();
    }

    #[Override]
    public function findByIds(array $ids): array
    {
        return Image::find($ids)
            ->map(fn (Image $image): DomainImage => $image->toDomain())
            ->all();
    }

    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        $paginator = Image::query()->paginate(
            perPage: $pageable->perPage,
            page: $pageable->page,
        );

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (Image $image): DomainImage => $image->toDomain(),
        );
    }
}
