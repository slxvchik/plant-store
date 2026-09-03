<?php

declare(strict_types=1);

namespace App\Application\Media\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class InvalidMimeTypeException extends AppException
{
    public function __construct(string $mimeType, array $supportedMimeTypes)
    {
        parent::__construct(
            AppExceptionStatus::INVALID_ARGUMENT,
            "Неподдерживаемый тип изображения: $mimeType. Пожалуйста, используйте один из следующих типов: " . implode(', ', $supportedMimeTypes)
        );
    }
}
