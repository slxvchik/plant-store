<?php

declare(strict_types=1);

namespace App\Application\Media\GetImagesByIds;

use App\Application\Media\Shared\Dto\Response\ImageResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetImagesByIdsUseCase
{
    /**
     * @return ImageResponseDto[]
     */
    public function execute(array $ids): array;
}
