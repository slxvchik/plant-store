<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\Media\CreateImage\CreateImageUseCase;
use App\Application\Media\DeleteImage\DeleteImageUseCase;
use App\Application\Media\UpdateImage\UpdateImageUseCase;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Notification\Notification;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    public function __construct(
        private readonly CreateImageUseCase $createImageUseCase,
        private readonly UpdateImageUseCase $updateImageUseCase,
        private readonly DeleteImageUseCase $deleteImageUseCase,
    ) {}

    public function store(StoreImageRequest $request): JsonResponse
    {
        return response()->json([
            'created' => $this->createImageUseCase->execute($request->toDto()),
        ]);
    }

    public function update(UpdateImageRequest $request, string $id): JsonResponse
    {
        $this->updateImageUseCase->execute($request->toDto($id));

        return response()->json([
            'notification' => Notification::success("Изображение с id: $id обновлено."),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->deleteImageUseCase->execute($id);

        return response()->json([
            'notification' => Notification::success("Изображение с id: $id удалено."),
        ]);
    }
}
