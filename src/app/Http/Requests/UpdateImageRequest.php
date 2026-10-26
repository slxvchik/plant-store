<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Application\Media\UpdateImage\UpdateImageRequestDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateImageRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'titleText' => ['sometimes', 'nullable', 'string', 'max:255'],
            'altText' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }

    public function toDto(string $id): UpdateImageRequestDto
    {
        /** @var array{titleText?: ?string, altText?: ?string} $data */
        $data = $this->validated();

        return new UpdateImageRequestDto(
            id: $id,
            titleText: $data['titleText'] ?? null,
            altText: $data['altText'] ?? null,
        );
    }
}
