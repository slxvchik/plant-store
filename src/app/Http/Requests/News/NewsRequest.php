<?php

declare(strict_types=1);

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

abstract class NewsRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'alias' => ['required', 'string', 'max:128'],
            'sort' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:256'],
            'active' => ['required', 'boolean'],
            'description' => ['sometimes', 'nullable', 'string'],
        ];
    }

    /**
     * @return array{alias: string, sort: int, name: string, active: bool, description: ?string}
     */
    protected function newsData(): array
    {
        /** @var array{alias: string, sort: int, name: string, active: bool, description?: ?string} $data */
        $data = $this->validated();

        return [
            'alias' => $data['alias'],
            'sort' => $data['sort'],
            'name' => $data['name'],
            'active' => $data['active'],
            'description' => $data['description'] ?? null,
        ];
    }
}
