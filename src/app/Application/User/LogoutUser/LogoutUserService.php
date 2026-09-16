<?php

declare(strict_types=1);

namespace App\Application\User\LogoutUser;

use App\Domain\User\Repository\SessionRepository;
use Override;

readonly class LogoutUserService implements LogoutUserUseCase
{
    public function __construct(
        private SessionRepository $sessionRepository
    ) {}

    #[Override]
    public function execute(string $token): void
    {
        $session = $this->sessionRepository->find($token);
        if ($session !== null) {
            $this->sessionRepository->delete($session->token->value);
        }
    }
}
