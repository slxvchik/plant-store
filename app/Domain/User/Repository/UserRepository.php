<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\User\Model\UserModel;

interface UserRepository
{
    public function create(UserModel $user): string;

    public function update(UserModel $user): void;

    public function delete(string $id): void;

    public function findById(string $id): ?UserModel;

    /**
     * @param  string[]  $ids
     * @return UserModel[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Page<UserModel>
     */
    public function findPage(Pageable $pageable): Page;

    public function findByPhone(string $phone): ?UserModel;

    public function findByEmail(string $email): ?UserModel;

    public function findByEmailConfirmToken(string $confirmToken): ?UserModel;
}
