<?php

declare(strict_types=1);

namespace App\Domain\User\Models;

enum Role: string
{
    case USER = "USER";
    case ADMINISTRATOR = "ADMIN";
    case MANAGER = "MANAGER";
    case WAREHOUSE_WORKER = "WAREHOUSE_WORKER";
}
