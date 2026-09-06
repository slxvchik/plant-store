<?php

namespace App\Domain\Order\Models;

enum OrderStatus
{
    case CREATED;
    case CANCELLED;
    case COMPLETED;
}
