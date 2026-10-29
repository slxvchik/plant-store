<?php

declare(strict_types=1);

namespace App\Application\News\GetNewsPage;

use App\Application\News\Shared\Dto\Response\NewsResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetNewsPageUseCase
{
    /**
     * @return Page<NewsResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
