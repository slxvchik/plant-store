<?php

namespace App\Application\UserRequest\DeleteUserRequest;

use App\Application\UserRequest\GetUserRequests\DeleteUserRequestUseCase;
use App\Application\UserRequest\Shared\UserRequestNotFoundException;
use App\Domain\UserRequest\Repository\UserRequestRepository;

readonly class DeleteUserRequestService implements DeleteUserRequestUseCase
{
    public function __construct(
        private UserRequestRepository $userRequestRepository
    ) {}

    public function execute(string $id): void
    {
        $userRequest = $this->userRequestRepository->findById($id);
        if ($userRequest === null) {
            throw new UserRequestNotFoundException();
        }
        $this->userRequestRepository->delete($id);
    }
}
