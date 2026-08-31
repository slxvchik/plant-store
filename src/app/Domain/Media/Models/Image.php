<?php

declare(strict_types=1);

namespace App\Domain\Media\Models;

use App\Domain\Shared\Uuid\Uuid;

class Image
{
    private const string STORAGE_PATH = '';
    private(set) final Uuid $id;
    private(set) string $pathToFile;
}