<?php

namespace App\Domain\User\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class UserInvalidEmailConfirmTokenException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::INVALID_ARGUMENT,
            "Произошла ошибка при подтверждении почты. Код подтверждения не валиден."
        );
    }
}
