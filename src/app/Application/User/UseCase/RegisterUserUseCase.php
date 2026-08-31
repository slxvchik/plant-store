<?php

declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Application\User\Dto\Request\RegisterUserRequestDto;

interface RegisterUserUseCase
{
    /**
     * must return token
     */
    public function execute(RegisterUserRequestDto $registerUserDto): string;
}
