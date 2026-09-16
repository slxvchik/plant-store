<?php

declare(strict_types=1);

namespace App\Application\User\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;
use Override;

class UserInvalidCredentialsException extends AppException
{
    #[Override]
    public function __construct()
    {
        parent::__construct(AppExceptionStatus::NOT_FOUND, "Неверный email или пароль.");
    }
}
