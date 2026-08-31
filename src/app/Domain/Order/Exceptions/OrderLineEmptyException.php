<?php

namespace App\Domain\Product\Exceptions;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class OrderLineEmptyException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::BUSINESS_ERROR,
            "Невозможно создать заказ без товара. Пожалуйста добавьте товар в корзину и оформите заказ."
        );
    }
}
