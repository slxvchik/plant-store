<?php

declare(strict_types=1);

namespace App\Application\User\SendUserEmailConfirmToken;

interface SendUserEmailConfirmTokenUseCase
{
    public function execute(string $userId): void;
}
