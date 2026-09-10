<?php

declare(strict_types=1);

namespace App\Application\Tag\UpdateTag;

interface UpdateTagUseCase
{
    public function execute(UpdateTagRequestDto $updateTagRequestDto): void;
}
