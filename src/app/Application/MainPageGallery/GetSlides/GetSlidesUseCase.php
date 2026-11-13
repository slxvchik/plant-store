<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\GetSlides;

use App\Application\MainPageGallery\Shared\Dto\Response\SlideResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetSlidesUseCase
{
    /**
     * @param Pageable $pageable
     * @return Page<SlideResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
