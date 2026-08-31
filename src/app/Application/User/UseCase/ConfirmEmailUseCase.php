<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

interface ConfirmEmailUseCase
{
    public function execute(string $confirmToken): void;
}
