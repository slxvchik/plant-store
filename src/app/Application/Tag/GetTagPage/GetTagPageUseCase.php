<?php

declare(strict_types=1);

namespace App\Application\Tag\GetTagPage;

use App\Application\Tag\Shared\Dto\Response\TagResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetTagPageUseCase
{
    /**
     * @return Page<TagResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
