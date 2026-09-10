<?php

namespace App\Application\Warehouse\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;
use Override;

class WarehouseNotFound extends AppException
{
    #[Override]
    public function __construct()
    {
        parent::__construct(AppExceptionStatus::NOT_FOUND, "Склад не найден.");
    }
}
