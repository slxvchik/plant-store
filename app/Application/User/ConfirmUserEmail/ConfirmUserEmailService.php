<?php

declare(strict_types=1);

namespace App\Application\User\ConfirmUserEmail;

use Override;

readonly class ConfirmUserEmailService implements ConfirmUserEmailUseCase
{
    public function __construct()
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function execute(string $confirmToken): void
    {
        throw new \Exception('Not implemented');
    }
}
