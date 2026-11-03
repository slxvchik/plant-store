<?php

declare(strict_types=1);

namespace App\Application\User\DeleteUser;

use App\Application\User\Shared\Exception\UserNotFoundException;

interface DeleteUserUseCase
{
    /**
     * @throws UserNotFoundException
     */
    public function execute(string $id): void;
}
