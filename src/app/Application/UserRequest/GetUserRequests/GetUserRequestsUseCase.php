<?php

declare(strict_types=1);

namespace App\Application\UserRequest\GetUserRequests;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetUserRequestsUseCase
{
    /**
     * @return Page<GetUserRequestsResponseDto>
     */
    function execute(Pageable $pageable): Page;
}
