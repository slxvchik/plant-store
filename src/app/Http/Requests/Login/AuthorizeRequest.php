<?php

namespace App\Http\Requests\Login;

use App\Application\User\AuthenticateUser\AuthenticateUserRequestDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthorizeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function toDto(): AuthenticateUserRequestDto
    {
        $data = $this->validated();

        return new AuthenticateUserRequestDto(
            email: $data['login'],
            password: $data['password'],
        );
    }
}
