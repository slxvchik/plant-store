<?php

declare(strict_types=1);

namespace App\Application\User\Shared\Dto\Response;

use App\Domain\User\Model\User;
use JsonSerializable;
use Override;

readonly class UserResponseDto implements JsonSerializable
{
    /**
     * @param  string[]  $roles
     */
    public function __construct(
        public string $id,
        public string $firstName,
        public ?string $lastName,
        public string $email,
        public bool $emailConfirmed,
        public string $phone,
        public ?string $imageId,
        public array $roles,
        public string $createdAt,
        public string $updatedAt,
    ) {}

    public static function fromDomain(User $user): self
    {
        $roles = [];
        foreach ($user->roles as $role) {
            $roles[] = $role->value;
        }

        return new self(
            id: $user->id->value,
            firstName: $user->firstName,
            lastName: $user->lastName,
            email: $user->email,
            emailConfirmed: $user->emailConfirmed,
            phone: $user->phone,
            imageId: $user->imageId,
            roles: $roles,
            createdAt: $user->createdAt->format('Y-m-d H:i:s'),
            updatedAt: $user->updatedAt?->format('Y-m-d H:i:s') ?? $user->createdAt->format('Y-m-d H:i:s'),
        );
    }

    /**
     * @return array{id: string, firstName: string, lastName: ?string, email: string, emailConfirmed: bool, phone: string, imageId: ?string, roles: string[], createdAt: string, updatedAt: string}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'emailConfirmed' => $this->emailConfirmed,
            'phone' => $this->phone,
            'imageId' => $this->imageId,
            'roles' => $this->roles,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }
}
