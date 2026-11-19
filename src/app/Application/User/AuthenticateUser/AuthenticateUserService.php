<?php

declare(strict_types=1);

namespace App\Application\User\AuthenticateUser;

use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\User\Exception\UserInvalidCredentialsException;
use App\Domain\User\Exception\UserPasswordEmptyException;
use App\Domain\User\Model\SessionModel;
use App\Domain\User\Repository\SessionRepository;
use App\Domain\User\Repository\UserRepository;
use Override;

readonly class AuthenticateUserService implements AuthenticateUserUseCase
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    /**
     * @throws UserPasswordEmptyException
     * @throws UserInvalidCredentialsException
     */
    #[Override]
    public function execute(AuthenticateUserRequestDto $authorizeUserRequestDto): string
    {
        $user = $this->userRepository->findByEmail($authorizeUserRequestDto->email);
        if ($user === null) {
            throw new UserInvalidCredentialsException;
        }

        if (! $user->isCurrentPassword($authorizeUserRequestDto->password)) {
            throw new UserInvalidCredentialsException;
        }

        return $user->id->value;
    }
}
