<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

interface ChangeUserPasswordUseCase
{
    public function execute(string $userId, string $oldPassword, string $newPassword): void;
}
