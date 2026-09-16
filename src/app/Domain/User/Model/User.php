<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

use App\Domain\Shared\Event\Eventable;
use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\User\Event\SendConfirmEmailEvent;
use App\Domain\User\Exception\UserBadPasswordException;
use App\Domain\User\Exception\UserEmailMismatchException;
use App\Domain\User\Exception\UserGenerateEmailConfirmTokenException;
use App\Domain\User\Exception\UserInvalidEmailConfirmTokenException;
use App\Domain\User\Exception\UserPasswordEmptyException;
use App\Domain\User\Exception\UserWrongPasswordException;
use DateTimeImmutable;
use Random\RandomException;

class User
{
    use Eventable;

    private const string PASSWORD_PATTERN = '/(?=.*[A-Za-z])(?=.*\d)(?=.*[*)(!@#$%_^&-])[A-Za-z\d*)(!@#$%_^&-]{8,}/';

    private(set) final Uuid $id;
    private string $passwordHash;
    private(set) string $firstName {
        set {
            $this->firstName = trim($value);
        }
    }
    private(set) ?string $lastName {
        set {
            $cleanVal = trim($value);
            if (!empty($cleanVal)) {
                $this->lastName = $cleanVal;
            }
        }
    }
    private(set) string $email {
        set {
            $this->email = trim($value);
        }
    }
    private ?string $emailConfirmToken;
    private(set) bool $emailConfirmed;
    private(set) string $phone;
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
    private function __construct(Uuid $id, string $passwordHash, string $firstName, ?string $lastName, string $email, ?string $emailConfirmToken, bool $emailConfirmed, string $phone, ?string $imageId, array $roles, DateTimeImmutable $createdAt, ?DateTimeImmutable $updatedAt)
    {
        $this->id = $id;
        $this->passwordHash = $passwordHash;
        $this->firstName = $firstName;
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

    public static function fromDb(Uuid $id, string $passwordHash, string $firstName, ?string $lastName, string $email, ?string $emailConfirmToken, bool $emailConfirmed, string $phone, ?string $imageId, array $roles, DateTimeImmutable $createdAt, ?DateTimeImmutable $updatedAt): self
    {
        return new self(
            id: $id,
            passwordHash: $passwordHash,
            firstName: $firstName,
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

    public static function createNew(UuidGeneratorInterface $uuidGenerator, string $password, string $firstName, ?string $lastName, string $email, string $phone): self
    {
        $uuidStr = $uuidGenerator->generate();
        $id = new Uuid($uuidStr);

        $confirmToken = self::generateEmailConfirmToken();

        $user = new self(
            id: $id,
            passwordHash: self::generatePasswordHash($password),
            firstName: $firstName,
            lastName: $lastName,
            email: $email,
            emailConfirmToken: $confirmToken,
            emailConfirmed: false,
            phone: $phone,
            imageId: null,
            roles: [Role::USER],
            createdAt: new DateTimeImmutable(),
            updatedAt: null
        );

        $user->recordEvent(new SendConfirmEmailEvent(
            userId: $user->id->value,
            email: $user->email,
            confirmToken: $confirmToken
        ));

        return $user;
    }

    /**
     * A method for administrators or users with roles
     * that can modify user access and data directly,
     * without requiring confirmations or additional permissions.
     * This method doesn't generate events.
     */
    public function silentUpdate(?string $password, string $firstname, ?string $lastName, string $email, bool $emailConfirmed, string $phone, ?string $imageId, array $roles): void
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

    public function update(string $firstname, ?string $lastName, string $phone, ?string $imageId): void
    {
        $this->firstName = $firstname;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->imageId = $imageId;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function updateEmail(string $newEmail): void
    {
        $confirmToken = self::generateEmailConfirmToken();

        $this->email = $newEmail;
        $this->emailConfirmToken = $confirmToken;
        $this->emailConfirmed = false;
        $this->updatedAt = new DateTimeImmutable();

        $this->recordEvent(new SendConfirmEmailEvent(
            userId: $this->id->value,
            email: $newEmail,
            confirmToken: $confirmToken
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

    public function changePassword(string $oldPassword, string $newPassword): void
    {
        if (!$this->isCurrentPassword($oldPassword)) {
            throw new UserWrongPasswordException();
        }

        $this->passwordHash = self::generatePasswordHash($newPassword);
        $this->updatedAt = new DateTimeImmutable();
    }

    public function isCurrentPassword(string $password): bool
    {
        if (trim($password) === '') {
            throw new UserPasswordEmptyException();
        }
        return hash_equals($this->passwordHash, self::getPasswordHash($password));
    }

    /**
     * Min length 8 chars.
     * Min 1 special symbol.
     * Min 1 letter.
     * Min 1 number.
     */
    private static function generatePasswordHash(string $password): string
    {
        $cleanPassword = trim($password);
        if (!preg_match(self::PASSWORD_PATTERN, $cleanPassword)) {
            throw new UserBadPasswordException();
        }
        return self::getPasswordHash($cleanPassword);
    }

    private static function getPasswordHash(string $password): string
    {
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
