<?php

namespace App\Domain\User\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class UserGenerateEmailConfirmTokenException extends AppException
{
    public function __construct()
    {
        parent::__construct(
            AppExceptionStatus::INTERNAL_ERROR,
            'Произошла ошибка при генерации подтверждения. Пожалуйста обновите страницу и отправьте код подтверждения ещё раз.'
        );
    }
}
