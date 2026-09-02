<?php

declare(strict_types=1);

namespace App\Application\Tag\UseCase;

use App\Application\Tag\Dto\Response\TagResponseDto;

interface GetTagByIdUseCase
{
    public function execute(string $id): TagResponseDto;
}
