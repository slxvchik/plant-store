<?php

declare(strict_types=1);

namespace App\Application\User\RegisterUser;

use App\Application\User\Shared\Exception\UserEmailAlreadyExistsException;
use App\Application\User\Shared\Exception\UserPhoneAlreadyExistsException;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\SessionRepository;
use App\Domain\User\Repository\UserRepository;
use Override;

readonly class RegisterUserService implements RegisterUserUseCase
{
    public function __construct(
        private UuidGeneratorInterface $uuidGeneratorInterface,
        private SessionRepository $sessionRepository,
        private UserRepository $userRepository
    ) {}

    #[Override]
    public function execute(RegisterUserRequestDto $registerUserDto): string
    {
        $user = User::createNew(
            uuidGenerator: $this->uuidGeneratorInterface,
            phone: $registerUserDto->phone,
            password: $registerUserDto->password,
            firstName: $registerUserDto->firstname,
            lastName: $registerUserDto->lastName,
            email: $registerUserDto->email
        );

        $existingUserByPhone = $this->userRepository->findByPhone($user->phone);
        if ($existingUserByPhone !== null) {
            throw new UserPhoneAlreadyExistsException();
        }

        if ($user->email !== null) {
            $existingUserByEmail = $this->userRepository->findByEmail($user->email);
            if ($existingUserByEmail !== null) {
                throw new UserEmailAlreadyExistsException();
            }
        }

        return $this->userRepository->create($user);
    }
}
