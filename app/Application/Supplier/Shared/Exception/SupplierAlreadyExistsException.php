<?php

declare(strict_types=1);

namespace App\Application\Supplier\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class SupplierAlreadyExistsException extends AppException
{
    public function __construct(string $field, string $value)
    {
        parent::__construct(AppExceptionStatus::ALREADY_EXISTS, "Поставщик с {$field} «{$value}» уже существует.");
    }
}
