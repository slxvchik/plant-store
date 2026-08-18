<?php

namespace App\Domain\User\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class UserBadPasswordException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::INVALID_ARGUMENT,
            "Пароль не соответствует требованиям. Пароль должен быть длиннее 8 символов, содержать хотя бы один спецсимвол: <b>*)(!@#$%_^&-</b> и хотя бы одно число."
        );
    }
}
