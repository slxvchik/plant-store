<?php

namespace App\Domain\Product\Exceptions;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class ProductSkuSetReservedException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::BUSINESS_ERROR,
            "Количество зарезервированного товара не может быть отрицательным."
        );
    }
}
