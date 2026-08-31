<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

interface LogoutUseCase
{
    public function execute(string $userId): void;
}