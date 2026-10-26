<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Application\Tag\UpdateTag\UpdateTagRequestDto;

class UpdateTagRequest extends TagRequest
{
    public function toDto(string $id): UpdateTagRequestDto
    {
        return new UpdateTagRequestDto(...['id' => $id, ...$this->tagData()]);
    }
}
