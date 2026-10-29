<?php

declare(strict_types=1);

namespace App\Http\Requests\MainPageGallery;

use App\Application\MainPageGallery\UpdateSlide\UpdateSlideRequestDto;

class UpdateMainPageGalleryRequest extends MainPageGalleryRequest
{
    public function toDto(string $id): UpdateSlideRequestDto
    {
        return new UpdateSlideRequestDto($id, ...$this->slideData());
    }
}
