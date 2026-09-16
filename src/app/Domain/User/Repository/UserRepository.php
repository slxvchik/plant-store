<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\Shared\BaseRepository\BaseRepository;
use App\Domain\User\Model\User;

/**
 * @extends BaseRepository<User>
 */
interface UserRepository extends BaseRepository
{
    public function findByPhone(string $phone): User;

    public function findByEmail(string $email): User;

    public function findByEmailConfirmToken(string $confirmToken): User;
}
