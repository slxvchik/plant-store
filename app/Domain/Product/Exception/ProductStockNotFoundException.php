<?php

namespace App\Domain\Product\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class ProductStockNotFoundException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::NOT_FOUND,
            'Не найден склад, с которого возможно поставить товар. Пожалуйста обновите страницу или обратитесь к администратору.'
        );
    }
}
