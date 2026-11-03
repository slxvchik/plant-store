<?php

declare(strict_types=1);

namespace App\Application\MainPageGallery\DeleteSlide;

use App\Application\MainPageGallery\Shared\Exception\SlideNotFoundException;
use App\Domain\MainPageGallery\Repository\MainPageGalleryRepository;
use Override;

readonly class DeleteSlideService implements DeleteSlideUseCase
{
    public function __construct(
        private MainPageGalleryRepository $mainPageGalleryRepository
    ) {}

    /**
     * @throws SlideNotFoundException
     */
    #[Override]
    public function execute(string $id): void
    {
        if ($this->mainPageGalleryRepository->findById($id) === null) {
            throw new SlideNotFoundException;
        }

        $this->mainPageGalleryRepository->delete($id);
    }
}
