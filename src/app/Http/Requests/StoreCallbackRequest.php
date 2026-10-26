<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Application\UserRequest\SaveFormRequest\SaveFormRequestDto;
use Illuminate\Foundation\Http\FormRequest;

class StoreCallbackRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'fio' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:18'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'comment' => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function toDto(): SaveFormRequestDto
    {
        /** @var array{fio: string, phone: string, email?: ?string, comment?: ?string} $data */
        $data = $this->validated();

        return new SaveFormRequestDto(
            formId: 'callback-form',
            FIO: $data['fio'],
            email: $data['email'] ?? null,
            phone: $data['phone'],
            comment: $data['comment'] ?? null,
        );
    }
}
