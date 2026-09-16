<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

use App\Domain\Shared\Uuid\Uuid;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use DateTimeImmutable;

class Session
{
    /** @var int 7 days in milliseconds */
    const int EXPIRED_TIME = 1000 * 60 * 60 * 24 * 7;

    private function __construct(
        private(set) Uuid $token,
        private(set) string $userId,
        private(set) DateTimeImmutable $expiredDate,
    ) {}

    public static function fromDb(Uuid $token, string $userId, DateTimeImmutable $expiredDate): self
    {
        return new self(
            token: $token,
            userId: $userId,
            expiredDate: $expiredDate
        );
    }

    public static function createNew(UuidGeneratorInterface $uuidGeneratorInterface, string $userId): self
    {
        $token = $uuidGeneratorInterface->generate();
        $tokenUuid = new Uuid($token);

        $expiredDate = DateTimeImmutable::createFromTimestamp(time() + self::EXPIRED_TIME);

        return new self(
            token: $tokenUuid,
            userId: $userId,
            expiredDate: $expiredDate
        );
    }

    public function isExpired(): bool
    {
        return time() > $this->expiredDate;
    }
}
