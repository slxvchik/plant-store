<?php

namespace App\Http\Controllers;

use App\Application\Media\CreateImage\CreateImageRequestDto;
use App\Application\Media\CreateImage\CreateImageUseCase;
use App\Application\Media\DeleteImage\DeleteImageUseCase;
use App\Application\Media\UpdateImage\UpdateImageRequestDto;
use App\Application\Media\UpdateImage\UpdateImageUseCase;
use App\Domain\Media\Model\Media;
use App\Domain\Shared\AppException\AppException;
use App\Http\Requests\CreateImageRequest;
use App\Notification\Notification;
use App\Notification\NotificationType;
use Illuminate\Http\JsonResponse;
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
     * @throws AppException
     * @throws LogicException
     * @throws RuntimeException
     */
    public function store(CreateImageRequest $request): JsonResponse
    {
        $request->validated();

        $createdId = $this->createImageUseCase->execute($request->getCreateImageRequestDto());

        return response()->json([
            'created' => $createdId,
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $updateImageRequestDto = new UpdateImageRequestDto(
            id: $id,
            titleText: $request->input('image.title'),
            altText: $request->input('image.alt'),
        );

        $this->updateImageUseCase->execute($updateImageRequestDto);

        return response()->json([
            new Notification(
                message: "Изображение с id: $id обновлено.",
                type: NotificationType::SUCCESS,
            ),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->deleteImageUseCase->execute($id);

        return response()->json([
            new Notification(
                message: "Изображение с id: $id удалено.",
                type: NotificationType::SUCCESS,
            ),
        ]);
    }
}
