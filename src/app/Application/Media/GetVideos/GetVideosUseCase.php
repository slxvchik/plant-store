<?php

declare(strict_types=1);

namespace App\Application\Media\GetVideos;

use App\Application\Media\Dto\Request\VideoResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetVideosUseCase
{
    /**
     * @return Page<VideoResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
