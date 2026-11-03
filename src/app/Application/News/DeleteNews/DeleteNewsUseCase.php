<?php

declare(strict_types=1);

namespace App\Application\News\DeleteNews;

use App\Application\News\Shared\Exception\NewsNotFoundException;

interface DeleteNewsUseCase
{
    /**
     * @throws NewsNotFoundException
     */
    public function execute(string $id): void;
}
