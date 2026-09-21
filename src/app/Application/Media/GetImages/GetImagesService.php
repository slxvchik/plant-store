<?php

declare(strict_types=1);

namespace App\Application\Media\GetImages;

use App\Application\Media\Shared\Dto\Response\ImageResponseDto;
use App\Domain\Media\Repository\ImageRepository;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Shared\Pagination\Page;
use Override;

readonly class GetImagesService implements GetImagesUseCase
{
    public function __construct(
        private ImageRepository $imageRepository
    ) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        $page = $this->imageRepository->findPage($pageable);

        $imageResponseDtos = [];
        foreach ($page->items as $item) {
            $imageResponseDtos[] = ImageResponseDto::fromDomain($item);
        }

        return $page->changeItems($imageResponseDtos);
    }
}
