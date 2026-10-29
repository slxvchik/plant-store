<?php

declare(strict_types=1);

namespace App\Http\Requests\MainPageGallery;

use App\Application\MainPageGallery\CreateSlide\CreateSlideRequestDto;

class StoreMainPageGalleryRequest extends MainPageGalleryRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'imageId' => ['required', 'uuid', 'exists:images,id'],
        ];
    }

    public function toDto(): CreateSlideRequestDto
    {
        /** @var array{sort: int, imageId: string, preTitle: ?string, title: ?string, description: ?string, buttonLink: ?string, buttonText: ?string} $data */
        $data = $this->slideData();

        return new CreateSlideRequestDto(...$data);
    }
}
