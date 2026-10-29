<?php

declare(strict_types=1);

namespace App\Application\News\UpdateNews;

use App\Application\News\Shared\Exception\NewsAliasExistsException;
use App\Application\News\Shared\Exception\NewsNotFoundException;

interface UpdateNewsUseCase
{
    /**
     * @throws NewsNotFoundException
     * @throws NewsAliasExistsException
     */
    public function execute(UpdateNewsRequestDto $updateNewsRequestDto): void;
}
