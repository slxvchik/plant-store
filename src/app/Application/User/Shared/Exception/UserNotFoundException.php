<?php

declare(strict_types=1);

namespace App\Application\User\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;
use Override;

class UserNotFoundException extends AppException
{
    #[Override]
    public function __construct()
    {
        parent::__construct(AppExceptionStatus::NOT_FOUND, "Пользователь не найден.");
    }
}
