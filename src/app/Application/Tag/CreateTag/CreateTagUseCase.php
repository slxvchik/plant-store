<?php

declare(strict_types=1);

namespace App\Application\Tag\CreateTag;

interface CreateTagUseCase
{
    public function execute(CreateTagRequestDto $createTagRequestDto): string;
}
