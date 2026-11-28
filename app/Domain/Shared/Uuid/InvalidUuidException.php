<?php

declare(strict_types=1);

namespace App\Domain\Shared\Uuid;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class InvalidUuidException extends AppException
{
    public function __construct(string $uuid)
    {
        parent::__construct(
            AppExceptionStatus::INTERNAL_ERROR,
            "Неверно сгенерирован UUID: $uuid"
        );
    }
}
