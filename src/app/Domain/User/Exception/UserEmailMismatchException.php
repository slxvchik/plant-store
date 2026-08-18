<?php

namespace App\Domain\User\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class UserEmailMismatchException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::INVALID_ARGUMENT,
            "Произошла ошибка при подтверждении почты. Пожалуста укажите новую почту и инициируйте отправку кода подтверждения."
        );
    }
}
