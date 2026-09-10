<?php

declare(strict_types=1);

namespace App\Application\User\LogoutUser;

interface LogoutUserUseCase
{
    public function execute(string $userId): void;
}
