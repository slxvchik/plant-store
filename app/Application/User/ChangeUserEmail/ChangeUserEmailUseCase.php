<?php

declare(strict_types=1);

namespace App\Application\User\ChangeUserEmail;

interface ChangeUserEmailUseCase
{
    public function execute(string $userId, string $newEmail): void;
}
