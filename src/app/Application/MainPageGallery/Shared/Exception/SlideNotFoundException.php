<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class SlideNotFoundException extends AppException
{
    public function __construct()
    {
        parent::__construct(AppExceptionStatus::NOT_FOUND, 'Слайд не найден.');
    }
}
