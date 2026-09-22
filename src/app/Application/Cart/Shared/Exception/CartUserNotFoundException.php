<?php

declare(strict_types=1);

namespace App\Application\Cart\Shared\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class CartUserNotFoundException extends AppException
{
    public function __construct()
    {
        parent::__construct(AppExceptionStatus::NOT_FOUND, 'Пользователь корзины не найден.');
    }
}
