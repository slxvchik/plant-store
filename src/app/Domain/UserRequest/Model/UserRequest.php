<?php

namespace App\Domain\UserRequest\Model;

use App\Domain\Shared\Uuid\Uuid;

class UserRequest
{
    private(set) Uuid $id;
    private(set) ?string $FIO;
    private(set) ?string $email;
    private(set) ?string $phone;
    private(set) ?string $comment;
}
