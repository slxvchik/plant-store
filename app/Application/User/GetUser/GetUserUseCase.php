<?php

declare(strict_types=1);

namespace App\Application\User\GetUser;

use App\Application\User\Shared\Dto\Response\UserResponseDto;
use App\Application\User\Shared\Exception\UserNotFoundException;

interface GetUserUseCase
{
    /**
     * @throws UserNotFoundException
     */
    public function execute(string $id): UserResponseDto;
}
