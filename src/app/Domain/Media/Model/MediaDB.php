<?php

declare(strict_types=1);

namespace App\Domain\Media\Model;

use App\Domain\Shared\Uuid\Uuid;
use DateTimeImmutable;

abstract class MediaDB
{
    public readonly DateTimeImmutable $createdAt;

    public function __construct(
        public readonly Uuid   $id,
        public readonly string $webPathToFile,
        public readonly string $mimeType,
        public readonly int    $sizeInBytes
    ) {
        $this->createdAt = new DateTimeImmutable();
    }
}
