<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Application\User\UpdateUser\UpdateUserRequestDto;
use Illuminate\Validation\Rules\Enum;

class UpdateUserRequest extends UserRequest
{
    /**
     * @return array<string, list<string|Enum>>
     */
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
        ];
    }

    public function toDto(string $id): UpdateUserRequestDto
    {
        /** @var array{password?: ?string} $data */
        $data = $this->validated();

        return new UpdateUserRequestDto(...[
            'id' => $id,
            ...$this->userData(),
            'password' => $data['password'] ?? null,
        ]);
    }
}
