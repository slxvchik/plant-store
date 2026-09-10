<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;
use Override;

class ProductAliasExistsException extends AppException
{
    #[Override]
    public function __construct(string $alias)
    {
        parent::__construct(AppExceptionStatus::NOT_FOUND, "Продукт с алиасом $alias уже существует.");
    }
}
