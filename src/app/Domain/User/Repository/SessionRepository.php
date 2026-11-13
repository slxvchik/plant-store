<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Model\SessionModel;

interface SessionRepository
{
    public function find(string $token): ?SessionModel;

    public function create(SessionModel $session): string;

    public function delete(string $token): void;
}
