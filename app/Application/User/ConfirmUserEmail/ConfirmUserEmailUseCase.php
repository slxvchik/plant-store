<?php

declare(strict_types=1);

namespace App\Application\User\ConfirmUserEmail;

interface ConfirmUserEmailUseCase
{
    public function execute(string $confirmToken): void;
}
