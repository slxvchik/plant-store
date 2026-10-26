<?php

declare(strict_types=1);

namespace App\Domain\UserRequest\Repository;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\UserRequest\Model\UserRequest;

interface UserRequestRepository
{
    public function create(UserRequest $userRequest): string;

    public function delete(string $id): void;

    public function findById(string $id): ?UserRequest;

    /**
     * @return Page<UserRequest>
     */
    public function findPage(Pageable $pageable): Page;
}
