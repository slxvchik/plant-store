<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class UserWrongPasswordException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::INVALID_ARGUMENT,
            "Текущий пароль указан неверно."
        );
    }
}
