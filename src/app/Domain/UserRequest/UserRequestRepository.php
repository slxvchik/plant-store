<?php

declare(strict_types=1);

namespace App\Domain\UserRequest;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface UserRequestRepository
{
    public function create(UserRequestModel $userRequest): string;

    public function delete(string $id): void;

    public function findById(string $id): ?UserRequestModel;

    /**
     * @return Page<UserRequestModel>
     */
    public function findPage(Pageable $pageable): Page;
}
