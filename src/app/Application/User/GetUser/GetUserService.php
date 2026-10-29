<?php

declare(strict_types=1);

namespace App\Application\User\GetUser;

use App\Application\User\Shared\Dto\Response\UserResponseDto;
use App\Application\User\Shared\Exception\UserNotFoundException;
use App\Domain\User\Repository\UserRepository;
use Override;

readonly class GetUserService implements GetUserUseCase
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    /**
     * @throws UserNotFoundException
     */
    #[Override]
    public function execute(string $id): UserResponseDto
    {
        $user = $this->userRepository->findById($id);
        if ($user === null) {
            throw new UserNotFoundException;
        }

        return UserResponseDto::fromDomain($user);
    }
}
