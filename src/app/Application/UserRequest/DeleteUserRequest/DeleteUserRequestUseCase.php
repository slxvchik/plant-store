<?php

declare(strict_types=1);

namespace App\Application\UserRequest\GetUserRequests;

interface DeleteUserRequestUseCase
{
    function execute(string $id): void;
}
