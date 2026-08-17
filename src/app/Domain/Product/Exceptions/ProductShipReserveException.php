<?php

namespace App\Domain\Product\Exceptions;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class ProductShipReserveException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::BUSINESS_ERROR,
            "Невозможно отгрузить товар. Нехватает количества зарезервированного товара."
        );
    }
}
