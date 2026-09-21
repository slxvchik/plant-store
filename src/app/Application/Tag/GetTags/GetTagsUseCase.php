<?php

declare(strict_types=1);

namespace App\Application\Tag\GetTags;

use App\Application\Tag\Shared\Dto\Response\TagResponseDto;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;

interface GetTagsUseCase
{
    /**
     * @return Page<TagResponseDto>
     */
    public function execute(Pageable $pageable): Page;
}
