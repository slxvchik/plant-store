<?php

namespace App\Domain\Product\Exceptions;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class ProductSkuSetPriceException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::BUSINESS_ERROR,
            "Цена торгового предложения должна быть больше 0."
        );
    }
}
