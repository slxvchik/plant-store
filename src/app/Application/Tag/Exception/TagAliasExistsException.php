<?php

declare(strict_types=1);

namespace App\Application\Tag\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;
use Override;

class TagAliasExistsException extends AppException
{
    #[Override]
    public function __construct(string $alias)
    {
        parent::__construct(AppExceptionStatus::BUSINESS_ERROR, "Тег с алиасом $alias уже существует.");
    }
}
