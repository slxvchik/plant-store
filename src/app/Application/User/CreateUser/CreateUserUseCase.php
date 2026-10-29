<?php

declare(strict_types=1);

namespace App\Application\User\CreateUser;

use App\Application\User\Shared\Exception\UserEmailAlreadyExistsException;
use App\Application\User\Shared\Exception\UserPhoneAlreadyExistsException;

interface CreateUserUseCase
{
    /**
     * @throws UserEmailAlreadyExistsException
     * @throws UserPhoneAlreadyExistsException
     */
    public function execute(CreateUserRequestDto $createUserRequestDto): string;
}
