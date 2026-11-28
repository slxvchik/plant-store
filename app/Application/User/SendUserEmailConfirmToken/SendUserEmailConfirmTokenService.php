<?php

declare(strict_types=1);

namespace App\Application\User\SendUserEmailConfirmToken;

use Override;

readonly class SendUserEmailConfirmTokenService implements SendUserEmailConfirmTokenUseCase
{
    public function __construct()
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function execute(string $userId): void
    {
        throw new \Exception('Not implemented');
    }
}
