<?php

namespace App\Domain\Product\Exceptions;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class ProductFastSellQuantityException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::BUSINESS_ERROR,
            "Недостаточно товара для быстрой продажи. Возможно товар уже зарезервировали, пожалуйста обновите страницу или обратитесь к администратору."
        );
    }
}
