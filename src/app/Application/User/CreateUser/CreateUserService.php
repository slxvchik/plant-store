<?php

declare(strict_types=1);

namespace App\Application\User\CreateUser;

use App\Application\User\Shared\Exception\UserEmailAlreadyExistsException;
use App\Application\User\Shared\Exception\UserPhoneAlreadyExistsException;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\User\Model\Role;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepository;
use Override;

readonly class CreateUserService implements CreateUserUseCase
{
    public function __construct(
        private UserRepository $userRepository,
        private UuidGeneratorInterface $uuidGenerator,
    ) {}

    /**
     * @throws UserEmailAlreadyExistsException
     * @throws UserPhoneAlreadyExistsException
     */
    #[Override]
    public function execute(CreateUserRequestDto $createUserRequestDto): string
    {
        if ($this->userRepository->findByEmail($createUserRequestDto->email) !== null) {
            throw new UserEmailAlreadyExistsException;
        }

        if ($this->userRepository->findByPhone($createUserRequestDto->phone) !== null) {
            throw new UserPhoneAlreadyExistsException;
        }

        $user = User::createNew(
            uuidGenerator: $this->uuidGenerator,
            password: $createUserRequestDto->password,
            firstName: $createUserRequestDto->firstName,
            lastName: $createUserRequestDto->lastName,
            email: $createUserRequestDto->email,
            phone: $createUserRequestDto->phone,
        );

        $roles = [];
        foreach ($createUserRequestDto->roles as $role) {
            $roles[] = Role::from($role);
        }

        $user->silentUpdate(
            password: null,
            firstname: $createUserRequestDto->firstName,
            lastName: $createUserRequestDto->lastName,
            email: $createUserRequestDto->email,
            emailConfirmed: $createUserRequestDto->emailConfirmed,
            phone: $createUserRequestDto->phone,
            imageId: $createUserRequestDto->imageId,
            roles: $roles,
        );

        return $this->userRepository->create($user);
    }
}
