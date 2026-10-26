<?php

declare(strict_types=1);

namespace App\Http\Requests\Tag;

use App\Application\Tag\CreateTag\CreateTagRequestDto;

class StoreTagRequest extends TagRequest
{
    public function toDto(): CreateTagRequestDto
    {
        return new CreateTagRequestDto(...$this->tagData());
    }
}
