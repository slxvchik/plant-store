<?php

declare(strict_types=1);

namespace App\Application\User\DeleteUser;

use App\Application\User\Shared\Exception\UserNotFoundException;
use App\Domain\User\Repository\UserRepository;
use Override;

readonly class DeleteUserService implements DeleteUserUseCase
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    /**
     * @throws UserNotFoundException
     */
    #[Override]
    public function execute(string $id): void
    {
        if ($this->userRepository->findById($id) === null) {
            throw new UserNotFoundException;
        }

        $this->userRepository->delete($id);
    }
}
