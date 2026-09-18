<?php

declare(strict_types=1);

namespace App\Application\Order\CreateOrder\Exception;

use App\Domain\Shared\AppException\AppException;
use App\Domain\Shared\AppException\AppExceptionStatus;

class OrderEmptyCartException extends AppException
{
    public function __construct()
    {
        parent::__construct(AppExceptionStatus::BUSINESS_ERROR, 'Нельзя оформить заказ без товаров в корзине.');
    }
}
