<?php

declare(strict_types=1);

namespace App\Application\UserRequest\DeleteUserRequest;

interface DeleteUserRequestUseCase
{
    function execute(string $id): void;
}
