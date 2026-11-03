<?php

declare(strict_types=1);

namespace App\Application\News\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class NewsAliasExistsException extends AppException
{
    public function __construct(string $alias)
    {
        parent::__construct(AppExceptionStatus::BUSINESS_ERROR, "Новость с алиасом $alias уже существует.");
    }
}
