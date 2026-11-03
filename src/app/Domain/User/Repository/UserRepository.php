<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\User\Model\User;

interface UserRepository
{
    public function create(User $user): string;

    public function update(User $user): void;

    public function delete(string $id): void;

    public function findById(string $id): ?User;

    /**
     * @param  string[]  $ids
     * @return User[]
     */
    public function findByIds(array $ids): array;

    /**
     * @return Page<User>
     */
    public function findPage(Pageable $pageable): Page;

    public function findByPhone(string $phone): ?User;

    public function findByEmail(string $email): ?User;

    public function findByEmailConfirmToken(string $confirmToken): ?User;
}
