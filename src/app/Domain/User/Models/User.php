<?php

declare(strict_types=1);

namespace App\Domain\User\Models;

use App\Domain\Shared\Uuid\Uuid;
use DateTimeImmutable as DateTimeImmutableAlias;

class User
{
    private(set) Uuid $id;
    /**
     * @var string unique username for login
     */
    private(set) string $username;
    /**
     * @var string password hash
     */
    private(set) string $password;
    private(set) string $firstName;
    private(set) ?string $lastName;
    private(set) string $email;
    private(set) bool $emailConfirmed;
    private(set) ?string $phone;
    private(set) ?string $imageId;
    /**
     * @var Role[]
     */
    private(set) array $roles;
    private(set) DateTimeImmutableAlias $createdAt;
    private(set) DateTimeImmutableAlias $updatedAt;
}
