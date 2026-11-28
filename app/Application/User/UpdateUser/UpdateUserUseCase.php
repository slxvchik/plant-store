<?php

declare(strict_types=1);

namespace App\Application\User\UpdateUser;

use App\Application\User\Shared\Exception\UserEmailAlreadyExistsException;
use App\Application\User\Shared\Exception\UserNotFoundException;
use App\Application\User\Shared\Exception\UserPhoneAlreadyExistsException;

interface UpdateUserUseCase
{
    /**
     * @throws UserNotFoundException
     * @throws UserEmailAlreadyExistsException
     * @throws UserPhoneAlreadyExistsException
     */
    public function execute(UpdateUserRequestDto $updateUserRequestDto): void;
}
