<?php

declare(strict_types=1);

namespace App\Application\Media\GetImagesByIds;

use App\Application\Media\Shared\Dto\Response\ImageResponseDto;
use App\Application\Media\Shared\FileStorageInterface;
use App\Domain\Media\Repository\ImageRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use Illuminate\Support\Facades\Log;
use Override;

readonly class GetImagesByIdsService implements GetImagesByIdsUseCase
{
    public function __construct(
        private ImageRepository $imageRepository,
        private FileStorageInterface $fileStorage,
    ) {}

    #[Override]
    public function execute(array $ids): array
    {
        $images = $this->imageRepository->findByIds($ids);

        $imageResponseDtos = [];
        foreach ($images as $item) {
            $webPathToFile = $this->fileStorage->url($item->getFilePath());
            $imageResponseDtos[] = ImageResponseDto::fromDomain(
                image: $item,
                webPathToFile: $webPathToFile,
            );
        }

        return $imageResponseDtos;
    }
}
