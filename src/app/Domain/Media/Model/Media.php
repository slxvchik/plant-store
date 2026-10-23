<?php

declare(strict_types=1);

namespace App\Domain\Media\Model;

/**
 * Value object for media data
 */
readonly class Media
{
    public function __construct(
        public string $name,
        public string $mimeType,
        public string $tmpName,
        public int $error,
        public int $size,
    ) {}

    public function isValid(): bool
    {
        return $this->error === UPLOAD_ERR_OK && is_uploaded_file($this->tmpName);
    }
}
