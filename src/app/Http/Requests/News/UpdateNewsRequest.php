<?php

declare(strict_types=1);

namespace App\Http\Requests\News;

use App\Application\News\UpdateNews\UpdateNewsRequestDto;

class UpdateNewsRequest extends NewsRequest
{
    public function toDto(string $id): UpdateNewsRequestDto
    {
        return new UpdateNewsRequestDto(...['id' => $id, ...$this->newsData()]);
    }
}
