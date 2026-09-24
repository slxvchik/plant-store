<?php

declare(strict_types=1);

namespace App\Generators;

use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Illuminate\Support\Str;
use Override;

class UuidGenerator implements UuidGeneratorInterface
{
    #[Override]
    public function generate(): string
    {
        return (string) Str::uuid();
    }
}
