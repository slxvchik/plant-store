<?php

namespace App\Domain\Product\Exceptions;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class ProductQuantityRemoveReserveException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::BUSINESS_ERROR,
            "Произошла ошибка при удалении товара из резерва. Пожалуйста обновите страницу или обратитесь к администратору."
        );
    }
}
