<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

interface AuthorizeUserUseCase
{
    /**
     * must return token
     */
    public function execute(string $email, string $password): string;
}
