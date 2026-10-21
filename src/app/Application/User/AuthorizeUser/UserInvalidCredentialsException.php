<?php

declare(strict_types=1);

namespace App\Application\User\AuthorizeUser;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class UserInvalidCredentialsException extends AppException
{
    public function __construct()
    {
        parent::__construct(AppExceptionStatus::NOT_FOUND, 'Неверный email или пароль.');
    }
}
