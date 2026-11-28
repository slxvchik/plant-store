<?php

declare(strict_types=1);

namespace App\Adapters;

use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Illuminate\Support\Str;
use Override;

class UuidGeneratorImpl implements UuidGeneratorInterface
{
    #[Override]
    public function generate(): string
    {
        return (string) Str::uuid();
    }
}
