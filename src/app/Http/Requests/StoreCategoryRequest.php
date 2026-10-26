<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Application\Category\CreateCategory\CreateCategoryRequestDto;

class StoreCategoryRequest extends CategoryRequest
{
    public function toDto(): CreateCategoryRequestDto
    {
        return new CreateCategoryRequestDto(...$this->categoryData());
    }
}
