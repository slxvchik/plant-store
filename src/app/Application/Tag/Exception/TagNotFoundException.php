<?php

declare(strict_types=1);

namespace App\Application\Tag\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;
use Override;

class TagNotFoundException extends AppException
{
    #[Override]
    public function __construct(?string $id = null)
    {
        $extra = "";
        if ($id !== null) {
            $extra .= " id: $id.";
        }
        parent::__construct(AppExceptionStatus::NOT_FOUND, "Тег не найден.$extra");
    }
}
