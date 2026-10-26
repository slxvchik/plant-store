<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Model\User;

interface UserRepository
{
    public function create(User $user): string;

    public function findById(string $id): ?User;

    /**
     * @param  string[]  $ids
     * @return User[]
     */
    public function findByIds(array $ids): array;

    public function findByPhone(string $phone): ?User;

    public function findByEmail(string $email): ?User;

    public function findByEmailConfirmToken(string $confirmToken): ?User;
}
