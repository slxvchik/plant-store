<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

interface ChangeUserEmailUseCase
{
    public function execute(string $userId, string $newEmail): void;
}
