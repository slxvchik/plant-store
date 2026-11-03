<?php

declare(strict_types=1);

namespace App\Application\User\CreateUser;

readonly class CreateUserRequestDto
{
    /**
     * @param  string[]  $roles
     */
    public function __construct(
        public string $firstName,
        public ?string $lastName,
        public string $email,
        public string $phone,
        public string $password,
        public bool $emailConfirmed,
        public ?string $imageId,
        public array $roles,
    ) {}
}
