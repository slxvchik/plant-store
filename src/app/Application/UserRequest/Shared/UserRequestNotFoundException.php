<?php

namespace App\Application\UserRequest\Shared;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class UserRequestNotFoundException extends AppException
{
    public function __construct()
    {
        parent::__construct(AppExceptionStatus::NOT_FOUND, "Пользовательская заявка не найдена.");
    }
}
