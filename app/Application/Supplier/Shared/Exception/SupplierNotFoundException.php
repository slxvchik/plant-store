<?php

declare(strict_types=1);

namespace App\Application\Supplier\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class SupplierNotFoundException extends AppException
{
    public function __construct(?string $id = null)
    {
        $extra = $id === null ? '' : " id: $id.";
        parent::__construct(AppExceptionStatus::NOT_FOUND, "Поставщик не найден.$extra");
    }
}
