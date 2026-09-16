<?php

declare(strict_types=1);

namespace App\Application\Media\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;
use Override;

class ImageNotFoundException extends AppException
{
    #[Override]
    public function __construct()
    {
        parent::__construct(AppExceptionStatus::NOT_FOUND, 'Изображение не найдено.');
    }
}
