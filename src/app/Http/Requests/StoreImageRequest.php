<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Application\Media\CreateImage\CreateImageRequestDto;
use App\Domain\Media\Model\Media;
use App\Domain\Shared\AppException\AppException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class StoreImageRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'image', 'mimes:jpeg,png,webp', 'max:5120'],
            'altText' => ['sometimes', 'nullable', 'string', 'max:255'],
            'titleText' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'file.required' => 'Загружаемое изображение не найдено.',
            'file.file' => 'Переданный объект не является файлом.',
            'file.image' => 'Файл должен быть изображением.',
        ];
    }

    /**
     * @throws AppException
     */
    public function toDto(): CreateImageRequestDto
    {
        $file = $this->file('file');

        if (! $file instanceof UploadedFile) {
            throw new AppException(errorMessage: 'Неправильный формат загружаемого файла');
        }

        $media = new Media(
            name: $file->getClientOriginalName(),
            mimeType: $file->getMimeType(),
            tmpName: $file->getPathname(),
            error: $file->getError(),
            size: $file->getSize(),
        );

        /** @var array{altText?: ?string, titleText?: ?string} $data */
        $data = $this->validated();

        return new CreateImageRequestDto(
            media: $media,
            altText: $data['altText'] ?? null,
            titleText: $data['titleText'] ?? null,
        );
    }
}
