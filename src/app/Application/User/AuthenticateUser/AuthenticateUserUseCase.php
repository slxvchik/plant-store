<?php

declare(strict_types=1);

namespace App\Application\User\AuthenticateUser;

interface AuthenticateUserUseCase
{
    /**
     * Returns user ID and throws an exception in case of failure.
     */
    public function execute(AuthenticateUserRequestDto $authorizeUserRequestDto): string;
}
