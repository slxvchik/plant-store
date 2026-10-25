<?php

namespace App\Http\Controllers;

use App\Application\Media\CreateImage\CreateImageRequestDto;
use App\Application\Media\CreateImage\CreateImageUseCase;
use App\Application\Media\DeleteImage\DeleteImageUseCase;
use App\Application\Media\UpdateImage\UpdateImageRequestDto;
use App\Application\Media\UpdateImage\UpdateImageUseCase;
use App\Domain\Media\Model\Media;
use App\Http\Requests\StoreImageRequest;
use App\Notification\Notification;
use App\Notification\NotificationType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use LogicException;
use RuntimeException;

class ImageController extends Controller
{
    public function __construct(
        private readonly CreateImageUseCase $createImageUseCase,
        private readonly UpdateImageUseCase $updateImageUseCase,
        private readonly DeleteImageUseCase $deleteImageUseCase,
    ) {}

    /**
     * @throws LogicException
     * @throws RuntimeException
     */
    public function store(StoreImageRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $image = $validated['image'];

        $imageFile = $image['file'];

        $media = new Media(
            name: $imageFile->getClientOriginalName(),
            mimeType: $imageFile->getMimeType(),
            tmpName: $imageFile->getPathname(),
            error: $imageFile->getError(),
            size: $imageFile->getSize(),
        );

        $createImageRequestDto = new CreateImageRequestDto(
            media: $media,
            altText: $image['altText'] ?? null,
            titleText: $image['titleText'] ?? null,
        );

        $createdId = $this->createImageUseCase->execute($createImageRequestDto);

        return redirect()->back()->with([
            new Notification(
                message: "Изображение с id: $createdId создано.",
                type: NotificationType::SUCCESS,
            ),
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $updateImageRequestDto = new UpdateImageRequestDto(
            id: $id,
            titleText: $request->input('image.title'),
            altText: $request->input('image.alt'),
        );

        $this->updateImageUseCase->execute($updateImageRequestDto);

        return redirect()->back()->with([
            new Notification(
                message: "Изображение с id: $id обновлено.",
                type: NotificationType::SUCCESS,
            ),
        ]);
    }

    public function destroy($id): RedirectResponse
    {
        $this->deleteImageUseCase->execute($id);

        return redirect()->back()->with([
            new Notification(
                message: "Изображение с id: $id удалено.",
                type: NotificationType::SUCCESS,
            ),
        ]);
    }
}
