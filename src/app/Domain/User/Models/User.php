<?php

declare(strict_types=1);

namespace App\Domain\User\Models;

use App\Domain\Shared\Event\Eventable;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\User\Event\SendConfirmEmailEvent;
use App\Domain\User\Exception\UserBadPasswordException;
use App\Domain\User\Exception\UserEmailMismatchException;
use App\Domain\User\Exception\UserGenerateEmailConfirmTokenException;
use App\Domain\User\Exception\UserInvalidEmailConfirmTokenException;
use DateTimeImmutable;
use Random\RandomException;

class User
{
    use Eventable;

    private(set) Uuid $id;
    private string $passwordHash;
    private(set) string $firstName;
    private(set) ?string $lastName;
    private(set) string $email;
    private ?string $emailConfirmToken;
    private(set) bool $emailConfirmed;
    private(set) ?string $phone;
    private(set) ?string $imageId;
    /**
     * @var Role[]
     */
    private(set) array $roles;
    private(set) DateTimeImmutable $createdAt;
    private(set) ?DateTimeImmutable $updatedAt;

    /**
     * @param Role[] $roles
     */
    private function __construct(Uuid $id, string $passwordHash, string $firstname, ?string $lastName, string $email, ?string $emailConfirmToken, bool $emailConfirmed, ?string $phone, ?string $imageId, array $roles, DateTimeImmutable $createdAt, ?DateTimeImmutable $updatedAt)
    {
        $this->id = $id;
        $this->passwordHash = $passwordHash;
        $this->firstName = $firstname;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->emailConfirmToken = $emailConfirmToken;
        $this->emailConfirmed = $emailConfirmed;
        $this->phone = $phone;
        $this->imageId = $imageId;
        $this->roles = $roles;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    private static function fromDb(Uuid $id, string $passwordHash, string $firstname, ?string $lastName, string $email, ?string $emailConfirmToken, bool $emailConfirmed, ?string $phone, ?string $imageId, array $roles, DateTimeImmutable $createdAt, ?DateTimeImmutable $updatedAt): self
    {
        return new self(
            id: $id,
            passwordHash: $passwordHash,
            firstName: $firstname,
            lastName: $lastName,
            email: $email,
            emailConfirmToken: $emailConfirmToken,
            emailConfirmed: $emailConfirmed,
            phone: $phone,
            imageId: $imageId,
            roles: $roles,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );
    }

    private static function createNew(UuidGeneratorInterface $uuidGenerator, string $password, string $firstname, ?string $lastName, string $email): self
    {
        $uuidStr = $uuidGenerator->generate();
        $id = new Uuid($uuidStr);

        $user = new self(
            id: $id,
            passwordHash: self::generatePasswordHash($password),
            firstName: $firstname,
            lastName: $lastName,
            email: $email,
            emailConfirmToken: null,
            emailConfirmed: false,
            phone: null,
            imageId: null,
            roles: [Role::USER],
            createdAt: new DateTimeImmutable(),
            updatedAt: null
        );

        $user->recordEvent(new SendConfirmEmailEvent(
            userId: $user->id->value,
            email: $user->email,
            confirmToken: self::generateEmailConfirmToken()
        ));

        return $user;
    }

    /**
     * A method for administrators or users with roles
     * that can modify user access and data directly,
     * without requiring confirmations or additional permissions.
     * This method doesn't generate events.
     */
    public function silentUpdate(?string $password, string $firstname, ?string $lastName, string $email, bool $emailConfirmed, ?string $phone, ?string $imageId, array $roles): void
    {
        if ($password !== null) {
            $this->passwordHash = self::generatePasswordHash($password);
        }
        $this->firstName = $firstname;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->emailConfirmed = $emailConfirmed;
        $this->phone = $phone;
        $this->imageId = $imageId;
        $this->roles = $roles;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function update(string $firstname, ?string $lastName, ?string $phone, ?string $imageId): void
    {
        $this->firstName = $firstname;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->imageId = $imageId;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function updateEmail(string $newEmail): void
    {
        $this->email = $newEmail;
        $this->emailConfirmed = false;
        $this->updatedAt = new DateTimeImmutable();

        $this->recordEvent(new SendConfirmEmailEvent(
            userId: $this->id->value,
            email: $newEmail,
            confirmToken: self::generateEmailConfirmToken()
        ));
    }

    public function confirmEmail(string $newEmail, string $confirmToken): void
    {
        if ($this->email !== $newEmail) {
            throw new UserEmailMismatchException();
        }
        if ($this->emailConfirmToken !== $confirmToken) {
            throw new UserInvalidEmailConfirmTokenException();
        }
        $this->emailConfirmed = true;
        $this->emailConfirmToken = null;
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * Min length 8 chars.
     * Min 1 special symbol.
     * Min 1 letter.
     * Min 1 number.
     */
    private static function generatePasswordHash(string $password): string
    {
        if (!preg_match('/(?=.*[A-Za-z])(?=.*\d)(?=.*[*)(!@#$%_^&-])[A-Za-z\d*)(!@#$%_^&-]{8,}/', $password)) {
            throw new UserBadPasswordException();
        }
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private static function generateEmailConfirmToken(): string
    {
        try {
            $bytes = random_bytes(32);
            return bin2hex($bytes);
        } catch (RandomException) {
            throw new UserGenerateEmailConfirmTokenException();
        }
    }
}
