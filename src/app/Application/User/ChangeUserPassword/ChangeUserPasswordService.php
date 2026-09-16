<?php

declare(strict_types=1);

namespace App\Application\User\ChangeUserPassword;

use Override;

readonly class ChangeUserPasswordService implements ChangeUserPasswordUseCase
{
    public function __construct()
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function execute(string $userId, string $oldPassword, string $newPassword): void
    {
        throw new \Exception('Not implemented');
    }
}
