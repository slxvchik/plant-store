<?php

declare(strict_types=1);

namespace App\Application\User\UpdateUser;

use App\Application\User\Shared\Exception\UserEmailAlreadyExistsException;
use App\Application\User\Shared\Exception\UserNotFoundException;
use App\Application\User\Shared\Exception\UserPhoneAlreadyExistsException;
use App\Domain\User\Model\Role;
use App\Domain\User\Repository\UserRepository;
use Override;

readonly class UpdateUserService implements UpdateUserUseCase
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    /**
     * @throws UserNotFoundException
     * @throws UserEmailAlreadyExistsException
     * @throws UserPhoneAlreadyExistsException
     */
    #[Override]
    public function execute(UpdateUserRequestDto $updateUserRequestDto): void
    {
        $user = $this->userRepository->findById($updateUserRequestDto->id);
        if ($user === null) {
            throw new UserNotFoundException;
        }

        $existingByEmail = $this->userRepository->findByEmail($updateUserRequestDto->email);
        if ($existingByEmail !== null && $existingByEmail->id->value !== $user->id->value) {
            throw new UserEmailAlreadyExistsException;
        }

        $existingByPhone = $this->userRepository->findByPhone($updateUserRequestDto->phone);
        if ($existingByPhone !== null && $existingByPhone->id->value !== $user->id->value) {
            throw new UserPhoneAlreadyExistsException;
        }

        $roles = [];
        foreach ($updateUserRequestDto->roles as $role) {
            $roles[] = Role::from($role);
        }

        $user->silentUpdate(
            password: $updateUserRequestDto->password,
            firstname: $updateUserRequestDto->firstName,
            lastName: $updateUserRequestDto->lastName,
            email: $updateUserRequestDto->email,
            emailConfirmed: $updateUserRequestDto->emailConfirmed,
            phone: $updateUserRequestDto->phone,
            imageId: $updateUserRequestDto->imageId,
            roles: $roles,
        );

        $this->userRepository->update($user);
    }
}
