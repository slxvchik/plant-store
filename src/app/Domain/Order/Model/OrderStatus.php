<?php

namespace App\Domain\Order\Model;

enum OrderStatus
{
    case CREATED;
    case CANCELLED;
    case COMPLETED;
}
