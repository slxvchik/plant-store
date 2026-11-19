<?php

namespace App\Application\User\AuthenticateUser;

readonly class AuthenticateUserRequestDto
{
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
