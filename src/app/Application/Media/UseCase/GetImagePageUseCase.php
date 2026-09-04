<?php

declare(strict_types=1);

namespace App\Application\Media\UseCase;

use App\Application\Media\Dto\Response\ImageResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetImagePageUseCase
{
    /**
     * @return Page<ImageResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
