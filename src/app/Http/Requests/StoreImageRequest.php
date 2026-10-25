<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'array'],
            'image.file' => ['required', 'file', 'image', 'max:5120'],
            'image.altText' => ['nullable', 'string', 'max:255'],
            'image.titleText' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.file.required' => 'Загружаемое изображение не найдено.',
            'image.file.file' => 'Переданный объект не является файлом.',
            'image.file.image' => 'Файл должен быть изображением.',
        ];
    }

}
