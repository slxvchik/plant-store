<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Application\Category\UpdateCategory\UpdateCategoryRequestDto;

class UpdateCategoryRequest extends CategoryRequest
{
    public function toDto(string $id): UpdateCategoryRequestDto
    {
        return new UpdateCategoryRequestDto(...['id' => $id, ...$this->categoryData()]);
    }
}
