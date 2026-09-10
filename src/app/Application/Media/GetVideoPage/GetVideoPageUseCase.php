<?php

declare(strict_types=1);

namespace App\Application\Media\GetVideoPage;

use App\Application\Media\Dto\Request\VideoResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetVideoPageUseCase
{
    /**
     * @return Page<VideoResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
