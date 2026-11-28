<?php

namespace App\Domain\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class FieldRequiredException extends AppException
{
    public function __construct(string $field)
    {
        parent::__construct(
            AppExceptionStatus::BUSINESS_ERROR,
            "Не заполнено обязательное поле: $field"
        );
    }
}
