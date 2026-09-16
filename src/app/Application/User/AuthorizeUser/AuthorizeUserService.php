<?php

declare(strict_types=1);

namespace App\Application\User\AuthorizeUser;

use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Domain\User\Exception\UserInvalidCredentialsException;
use App\Domain\User\Model\Session;
use App\Domain\User\Repository\SessionRepository;
use App\Domain\User\Repository\UserRepository;
use Override;

readonly class AuthorizeUserService implements AuthorizeUserUseCase
{
    public function __construct(
        private UuidGeneratorInterface $uuidGeneratorInterface,
        private SessionRepository $sessionRepository,
        private UserRepository $userRepository
    ) {}

    #[Override]
    public function execute(string $email, string $password): string
    {
        $user = $this->userRepository->findByEmail($email);
        if ($user === null) {
            throw new UserInvalidCredentialsException();
        }

        if (!$user->isCurrentPassword($password)) {
            throw new UserInvalidCredentialsException();
        }

        $session = Session::createNew(
            uuidGeneratorInterface: $this->uuidGeneratorInterface,
            userId: $user->id->value
        );

        return $this->sessionRepository->create($session);
    }
}
