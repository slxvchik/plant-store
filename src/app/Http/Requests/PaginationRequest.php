<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Domain\Shared\Pagination\Pageable;
use Illuminate\Foundation\Http\FormRequest;

class PaginationRequest extends FormRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return [
            'page' => ['sometimes', 'integer', 'min:1'],
            'perPage' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function toPageable(): Pageable
    {
        /** @var array{page?: int, perPage?: int} $data */
        $data = $this->validated();

        return new Pageable(
            page: $data['page'] ?? 1,
            perPage: $data['perPage'] ?? 10,
        );
    }
}
