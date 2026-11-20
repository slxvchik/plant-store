<?php

declare(strict_types=1);

namespace App\Http\Requests\Private\Supplier;

use App\Http\Requests\Public\PaginationRequest;

class SupplierIndexRequest extends PaginationRequest
{
    /**
     * @return array<string, string[]>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'search' => ['sometimes', 'nullable', 'string', 'max:255'],
        ]);
    }

    public function search(): ?string
    {
        /** @var array{search?: ?string} $data */
        $data = $this->validated();
        $search = trim($data['search'] ?? '');

        return $search === '' ? null : $search;
    }
}
