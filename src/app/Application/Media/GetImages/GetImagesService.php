<?php

declare(strict_types=1);

namespace App\Application\Media\GetImages;

use App\Application\Media\Shared\Dto\Response\ImageResponseDto;
use App\Application\Media\Shared\FileStorageInterface;
use App\Domain\Media\Repository\ImageRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use Override;

readonly class GetImagesService implements GetImagesUseCase
{
    public function __construct(
        private ImageRepository $imageRepository,
        private FileStorageInterface $fileStorage,
    ) {}

    #[Override]
    public function execute(Pageable $pageable): Page
    {
        $page = $this->imageRepository->findPage($pageable);

        $imageResponseDtos = [];
        foreach ($page->items as $item) {
            $webPathToFile = $this->fileStorage->url($item->id->value);
            $imageResponseDtos[] = ImageResponseDto::fromDomain(
                image: $item,
                webPathToFile: $webPathToFile,
            );
        }

        return $page->changeItems($imageResponseDtos);
    }
}
