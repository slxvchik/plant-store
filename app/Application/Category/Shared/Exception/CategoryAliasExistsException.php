<?php

declare(strict_types=1);

namespace App\Application\Category\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class CategoryAliasExistsException extends AppException
{
    public function __construct(string $alias)
    {
        parent::__construct(AppExceptionStatus::NOT_FOUND, "Категория с алиасом $alias уже существует.");
    }
}
