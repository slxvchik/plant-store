<?php

declare(strict_types=1);

namespace App\Application\Tag\DeleteTag;

interface DeleteTagUseCase
{
    public function execute(string $id): void;
}
