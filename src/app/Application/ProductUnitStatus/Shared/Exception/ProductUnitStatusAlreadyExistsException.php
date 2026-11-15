<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class ProductUnitStatusAlreadyExistsException extends AppException
{
    public function __construct(string $name)
    {
        parent::__construct(AppExceptionStatus::ALREADY_EXISTS, "Статус с названием «{$name}» уже существует.");
    }
}
