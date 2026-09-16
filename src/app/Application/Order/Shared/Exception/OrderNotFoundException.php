<?php

declare(strict_types=1);

namespace App\Application\Order\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class OrderNotFoundException extends AppException
{
    public function __construct()
    {
        parent::__construct(AppExceptionStatus::NOT_FOUND, 'Заказ не найден.');
    }
}
