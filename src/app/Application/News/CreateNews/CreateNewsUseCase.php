<?php

declare(strict_types=1);

namespace App\Application\News\CreateNews;

use App\Application\News\Shared\Exception\NewsAliasExistsException;

interface CreateNewsUseCase
{
    /**
     * @throws NewsAliasExistsException
     */
    public function execute(CreateNewsRequestDto $createNewsRequestDto): string;
}
