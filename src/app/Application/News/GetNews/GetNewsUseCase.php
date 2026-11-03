<?php

declare(strict_types=1);

namespace App\Application\News\GetNews;

use App\Application\News\Shared\Dto\Response\NewsResponseDto;
use App\Application\News\Shared\Exception\NewsNotFoundException;

interface GetNewsUseCase
{
    /**
     * @throws NewsNotFoundException
     */
    public function execute(string $id): NewsResponseDto;
}
