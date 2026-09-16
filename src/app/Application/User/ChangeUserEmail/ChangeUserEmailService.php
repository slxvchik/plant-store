<?php

declare(strict_types=1);

namespace App\Application\User\ChangeUserEmail;

use Override;

readonly class ChangeUserEmailService implements ChangeUserEmailUseCase
{
    public function __construct()
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function execute(string $userId, string $newEmail): void
    {
        throw new \Exception('Not implemented');
    }
}
