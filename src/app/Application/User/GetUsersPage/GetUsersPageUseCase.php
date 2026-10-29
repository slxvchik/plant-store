<?php

declare(strict_types=1);

namespace App\Application\User\GetUsersPage;

use App\Application\User\Shared\Dto\Response\UserResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetUsersPageUseCase
{
    /**
     * @return Page<UserResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
