<?php

namespace App\Http\Requests;

use App\Application\Media\CreateImage\CreateImageRequestDto;
use App\Domain\Media\Model\Media;
use App\Domain\Shared\AppException\AppException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class CreateImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'image', 'max:5120'],
            'altText' => ['nullable', 'string', 'max:255'],
            'titleText' => ['nullable', 'string', 'max:255'],
        ];
    }

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
     * @throws \LogicException
     * @throws \RuntimeException
     */
    public function getCreateImageRequestDto(): CreateImageRequestDto
    {
        $file = $this->file('file');

        if (! $file instanceof UploadedFile) {
            throw new AppException(
                errorMessage: 'Неправильный формат загружаемого файла'
            );
        }

        $media = new Media(
            name: $file->getClientOriginalName(),
            mimeType: $file->getMimeType(),
            tmpName: $file->getPathname(),
            error: $file->getError(),
            size: $file->getSize(),
        );

        return new CreateImageRequestDto(
            media: $media,
            altText: $this->input('altText') ?? null,
            titleText: $this->input('titleText') ?? null,
        );
    }
}
