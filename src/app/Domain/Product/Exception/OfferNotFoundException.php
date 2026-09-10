<?php

namespace App\Domain\Product\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class OfferNotFoundException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::NOT_FOUND,
            "Торговое предложение не найдено. Пожалуйста обновите страницу."
        );
    }
}
