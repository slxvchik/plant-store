<?php

declare(strict_types=1);

namespace App\Domain\Media\Model;

/**
 * Value object for media data
 */
readonly class Media
{
    public string $name;
    public string $mimeType;
    public string $tmpName;
    public int $error;
    public int $size;

    /**
     * @param array{name: string, mimeType: string, tmp_name: string, error: int, size: int} $fileData
     */
    public function __construct(array $fileData) 
    {
        $this->name = (string)($fileData['name'] ?? '');
        $this->mimeType = (string)($fileData['mimeType'] ?? '');
        $this->tmpName = (string)($fileData['tmp_name'] ?? '');
        $this->error = (int)($fileData['error'] ?? UPLOAD_ERR_NO_FILE);
        $this->size = (int)($fileData['size'] ?? 0);
    }
    
    public function isValid(): bool 
    {
        return $this->error === UPLOAD_ERR_OK && is_uploaded_file($this->tmpName);
    }
}