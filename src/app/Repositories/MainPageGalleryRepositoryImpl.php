<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\MainPageGallery\MainPageGalleryModel;
use App\Domain\MainPageGallery\MainPageGalleryRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Models\MainPageGallery as MainPageGalleryModel;
use Override;

class MainPageGalleryRepositoryImpl implements MainPageGalleryRepository
{
    #[Override]
    public function create(MainPageGalleryModel $slide): string
    {
        MainPageGalleryModel::create($this->attributes($slide));

        return $slide->id->value;
    }

    #[Override]
    public function update(MainPageGalleryModel $slide): void
    {
        MainPageGalleryModel::findOrFail($slide->id->value)->update($this->attributes($slide));
    }

    #[Override]
    public function delete(string $id): void
    {
        MainPageGalleryModel::findOrFail($id)->delete();
    }

    #[Override]
    public function findById(string $id): ?MainPageGalleryModel
    {
        return MainPageGalleryModel::find($id)?->toDomain();
    }

    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        $page = MainPageGalleryModel::query()->paginate(
            perPage: $pageable->perPage,
            page: $pageable->page,
        );

        return PaginationAdapter::toDomainPage(
            paginator: $page,
            mapper: fn (MainPageGalleryModel $model) => $model->toDomain(),
        );
    }

    #[Override]
    public function search(?bool $active = null): array
    {
        return MainPageGalleryModel::orderBy('sort')
            ->get()
            ->map(fn (MainPageGalleryModel $slide): MainPageGalleryModel => $slide->toDomain())
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function attributes(MainPageGalleryModel $slide): array
    {
        return [
            'id' => $slide->id->value,
            'active' => $slide->active,
            'sort' => $slide->sort,
            'image_id' => $slide->imageId,
            'pre_title' => $slide->preTitle,
            'title' => $slide->title,
            'description' => $slide->description,
            'button_link' => $slide->buttonLink,
            'button_text' => $slide->buttonText,
        ];
    }
}
