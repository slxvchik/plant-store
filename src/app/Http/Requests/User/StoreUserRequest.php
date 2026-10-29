<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Application\User\CreateUser\CreateUserRequestDto;
use Illuminate\Validation\Rules\Enum;

class StoreUserRequest extends UserRequest
{
    /**
     * @return array<string, list<string|Enum>>
     */
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function toDto(): CreateUserRequestDto
    {
        /** @var array{password: string} $data */
        $data = $this->validated();

        return new CreateUserRequestDto(...[...$this->userData(), 'password' => $data['password']]);
    }
}
