<?php

declare(strict_types=1);

namespace App\Application\User\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;
use Override;

class UserEmailAlreadyExistsException extends AppException
{
    #[Override]
    public function __construct()
    {
        parent::__construct(AppExceptionStatus::ALREADY_EXISTS, "Email уже занят.");
    }
}
