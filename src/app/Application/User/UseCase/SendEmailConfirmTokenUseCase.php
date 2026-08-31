<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

interface SendEmailConfirmTokenUseCase
{
    public function execute(string $userId): void;
}
