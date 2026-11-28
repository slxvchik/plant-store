<?php

declare(strict_types=1);

namespace App\Application\User\RegisterUser;

interface RegisterUserUseCase
{
    /**
     * must return token
     */
    public function execute(RegisterUserRequestDto $registerUserDto): string;
}
