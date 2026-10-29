<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Domain\User\Model\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

abstract class UserRequest extends FormRequest
{
    /**
     * @return array<string, list<string|Enum>>
     */
    public function rules(): array
    {
        return [
            'firstName' => ['required', 'string', 'max:128'],
            'lastName' => ['sometimes', 'nullable', 'string', 'max:128'],
            'email' => ['required', 'email', 'max:256'],
            'phone' => ['required', 'string', 'max:32'],
            'emailConfirmed' => ['required', 'boolean'],
            'imageId' => ['sometimes', 'nullable', 'uuid', 'exists:images,id'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['required', 'string', Rule::enum(Role::class)],
        ];
    }

    /**
     * @return array{firstName: string, lastName: ?string, email: string, phone: string, emailConfirmed: bool, imageId: ?string, roles: string[]}
     */
    protected function userData(): array
    {
        /** @var array{firstName: string, lastName?: ?string, email: string, phone: string, emailConfirmed: bool, imageId?: ?string, roles: string[]} $data */
        $data = $this->validated();

        return [
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'],
            'emailConfirmed' => $data['emailConfirmed'],
            'imageId' => $data['imageId'] ?? null,
            'roles' => $data['roles'],
        ];
    }
}
