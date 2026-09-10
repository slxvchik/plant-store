<?php

namespace App\Domain\Order\Model;

enum OrderStatus: string
{
    case CREATED = "Новый";
    case INPROGRESS = "В обработке";
    case CANCELLED = "Отменён";
    case COMPLETED = "Завершён";
}
