<?php

declare(strict_types=1);

namespace App\Http\Requests\MainPageGallery;

use Illuminate\Foundation\Http\FormRequest;

abstract class MainPageGalleryRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'sort' => ['required', 'integer'],
            'imageId' => ['sometimes', 'nullable', 'uuid', 'exists:images,id'],
            'preTitle' => ['sometimes', 'nullable', 'string', 'max:256'],
            'title' => ['sometimes', 'nullable', 'string', 'max:256'],
            'description' => ['sometimes', 'nullable', 'string'],
            'buttonLink' => ['sometimes', 'nullable', 'string', 'max:512'],
            'buttonText' => ['sometimes', 'nullable', 'string', 'max:256'],
        ];
    }

    /**
     * @return array{sort: int, imageId: ?string, preTitle: ?string, title: ?string, description: ?string, buttonLink: ?string, buttonText: ?string}
     */
    protected function slideData(): array
    {
        /** @var array{sort: int, imageId?: ?string, preTitle?: ?string, title?: ?string, description?: ?string, buttonLink?: ?string, buttonText?: ?string} $data */
        $data = $this->validated();

        return [
            'sort' => $data['sort'],
            'imageId' => $data['imageId'] ?? null,
            'preTitle' => $data['preTitle'] ?? null,
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'buttonLink' => $data['buttonLink'] ?? null,
            'buttonText' => $data['buttonText'] ?? null,
        ];
    }
}
