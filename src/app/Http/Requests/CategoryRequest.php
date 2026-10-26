<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class CategoryRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'parentId' => ['sometimes', 'nullable', 'uuid', 'exists:categories,id'],
            'alias' => ['required', 'string', 'max:128'],
            'sort' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:128'],
            'active' => ['required', 'boolean'],
        ];
    }

    /**
     * @return array{parentId: ?string, alias: string, sort: int, name: string, active: bool}
     */
    protected function categoryData(): array
    {
        /** @var array{parentId?: ?string, alias: string, sort: int, name: string, active: bool} $data */
        $data = $this->validated();

        return [
            'parentId' => $data['parentId'] ?? null,
            'alias' => $data['alias'],
            'sort' => $data['sort'],
            'name' => $data['name'],
            'active' => $data['active'],
        ];
    }
}
