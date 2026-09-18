<?php

namespace App\Domain\Product\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class ProductPurchaseQuantityException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::BUSINESS_ERROR,
            "Недостаточно товара на складе. Возможно товар уже зарезервировали, пожалуйста обновите страницу или обратитесь к администратору."
        );
    }
}
