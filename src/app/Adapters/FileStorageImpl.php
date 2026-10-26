<?php

declare(strict_types=1);

namespace App\Adapters;

use App\Application\Media\Shared\FileStorageInterface;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class FileStorageImpl implements FileStorageInterface
{
    protected string $disk = 'public';

    public function put(string $path, string $contents): bool
    {
        return (bool) Storage::disk($this->disk)->put($path, $contents);
    }

    /**
     * @throws FileNotFoundException
     */
    public function putFile(string $localFilePath, string $targetPath): string|false
    {
        if (! file_exists($localFilePath)) {
            return false;
        }

        return Storage::disk($this->disk)->putFile($targetPath, new File($localFilePath));
    }

    public function get(string $path): string
    {
        return Storage::disk($this->disk)->get($path);
    }

    public function exists(string $path): bool
    {
        return Storage::disk($this->disk)->exists($path);
    }

    public function delete(string|array $paths): bool
    {
        return Storage::disk($this->disk)->delete($paths);
    }

    /**
     * @throws RuntimeException
     */
    public function url(string $path): string
    {
        return Storage::disk($this->disk)->url($path);
    }

    /**
     * @return resource
     *
     * @throws RuntimeException
     */
    public function readStream(string $path)
    {
        $stream = Storage::disk($this->disk)->readStream($path);

        if ($stream === null) {
            throw new RuntimeException("Файл не найден или недоступен для чтения: {$path}");
        }

        return $stream;
    }
}
