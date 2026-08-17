<?php

declare(strict_types=1);

namespace App\Domain\Shared\AppException;

use RuntimeException;

class AppException extends RuntimeException
{
    /**
     * @param AppExceptionStatus $appExceptionStatus
     * @param string $errorMessage
     */
    public function __construct(
        public readonly AppExceptionStatus $appExceptionStatus = AppExceptionStatus::INTERNAL_ERROR,
        public readonly string $errorMessage = 'Произошла неизвестная ошибка, пожалуйста попробуйте позднее.'
    ) {
        parent::__construct(message: $errorMessage);
    }
}
