<?php

namespace App\Domain\User\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class UserPasswordEmptyException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::INVALID_ARGUMENT,
            "Пароль не может быть пустым."
        );
    }
}
