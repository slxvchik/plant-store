<?php

declare(strict_types=1);

namespace App\Application\User\ChangeUserPassword;

interface ChangeUserPasswordUseCase
{
    public function execute(string $userId, string $oldPassword, string $newPassword): void;
}
