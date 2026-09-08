<?php

namespace App\Domain\Cart\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class CartLineNotFoundException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::BUSINESS_ERROR,
            "В корзине товар не найден. Пожалуйста обновите страницу и добавьте товар в корзину заново."
        );
    }
}
