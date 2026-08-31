<?php

declare(strict_types=1);

namespace App\Application\User\Dto\Request;

readonly class RegisterUserRequestDto
{
    public function __construct(
        public string $email,
        public string $password,
        public string $firstname,
        public ?string $lastName
    ) {}
}
