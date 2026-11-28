<?php

declare(strict_types=1);

namespace App\Application\User\RegisterUser;

readonly class RegisterUserRequestDto
{
    public function __construct(
        public string $phone,
        public string $email,
        public string $password,
        public string $firstname,
        public ?string $lastName
    ) {}
}
