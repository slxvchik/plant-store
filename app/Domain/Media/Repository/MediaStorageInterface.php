<?php

declare(strict_types=1);

namespace App\Domain\Media\Repository;

interface MediaStorageInterface
{
    public function store(string $temporaryPath, string $targetFileName): string;

    public function delete(string $webPathToFile): void;
}
