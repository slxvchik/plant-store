<?php

declare(strict_types=1);

namespace App\Application\Category\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class CategoryNotFoundException extends AppException
{
    public function __construct(?string $id = null)
    {
        $extra = '';
        if ($id !== null) {
            $extra .= " id: $id.";
        }
        parent::__construct(AppExceptionStatus::NOT_FOUND, "Категория не найдена.$extra");
    }
}
