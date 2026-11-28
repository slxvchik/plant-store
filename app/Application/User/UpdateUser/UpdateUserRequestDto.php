<?php

declare(strict_types=1);

namespace App\Application\User\UpdateUser;

readonly class UpdateUserRequestDto
{
    /**
     * @param  string[]  $roles
     */
    public function __construct(
        public string $id,
        public string $firstName,
        public ?string $lastName,
        public string $email,
        public string $phone,
        public ?string $password,
        public bool $emailConfirmed,
        public ?string $imageId,
        public array $roles,
    ) {}
}
