<?php

declare(strict_types=1);

namespace App\Domain\Media\Repositories;

interface MediaStorageInterface
{
    public function store(string $temporaryPath, string $targetFileName): string;

    public function delete(string $pathToFile): void;
}
