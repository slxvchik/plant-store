<?php

declare(strict_types=1);

namespace App\Application\User\Dto\Response;

use App\Domain\User\Models\Role;
use DateTimeImmutable;

readonly class GetProfileResponseDto
{
    /**
     * @param Role[] $roles
     */
    public function __construct(
        public string $id,
        public string $firstName,
        public ?string $lastName,
        public string $email,
        public bool $emailConfirmed,
        public ?string $phone,
        public ?string $imageId,
        public array $roles,
        public DateTimeImmutable $createdAt,
        public DateTimeImmutable $updatedAt
    ) {}
}
