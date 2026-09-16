<?php

namespace App\Domain\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class InternalException extends AppException
{
    public function __construct(?string $message = "")
    {
        parent::__construct(
            AppExceptionStatus::INTERNAL_ERROR,
            "Произошла внутренняя ошибка." . ($message ? " " . $message : "")
        );
    }
}
