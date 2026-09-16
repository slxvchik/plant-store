<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Model\Session;

interface SessionRepository
{
    public function find(string $token): Session;
    public function create(Session $session): string;
    public function delete(string $token): void;
}
