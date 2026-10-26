<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class TagRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'alias' => ['required', 'string', 'max:128'],
            'sort' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:128'],
            'active' => ['required', 'boolean'],
        ];
    }

    /**
     * @return array{alias: string, sort: int, name: string, active: bool}
     */
    protected function tagData(): array
    {
        /** @var array{alias: string, sort: int, name: string, active: bool} $data */
        $data = $this->validated();

        return $data;
    }
}
