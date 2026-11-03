<?php

declare(strict_types=1);

namespace App\Http\Requests\News;

use App\Application\News\CreateNews\CreateNewsRequestDto;

class StoreNewsRequest extends NewsRequest
{
    public function toDto(): CreateNewsRequestDto
    {
        return new CreateNewsRequestDto(...$this->newsData());
    }
}
