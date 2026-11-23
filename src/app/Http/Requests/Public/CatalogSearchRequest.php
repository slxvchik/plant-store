<?php

namespace App\Http\Requests\Public;

use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Domain\Product\Criteria\ProductSort;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class CatalogSearchRequest extends PaginationRequest
{
    public function prepareForValidation()
    {
        if ($this->has('categories') && is_string($this->input('categories'))) {
            $this->merge([
                'categories' => array_filter(explode(',', $this->input('categories'))),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'categories' => ['sometimes', 'array'],
            'categories.*' => ['string', 'exists:categories,alias'],
            'price_from' => ['sometimes', 'numeric', 'min:0'],
            'price_to' => ['sometimes', 'numeric', 'min:0'],
            'sort' => ['sometimes', 'string', Rule::enum(ProductSort::class)],
            'in_stock' => ['sometimes', 'boolean'],
        ]);
    }

    public function toCriteria(): ProductSearchCriteria
    {
        return new ProductSearchCriteria(
            categoryAliases: $this->validated('categories', []),
            minPrice: $this->filled('price_from') ? (float) $this->validated('price_from') : null,
            maxPrice: $this->filled('price_to') ? (float) $this->validated('price_to') : null,
            active: true,
            inStock: $this->filled('in_stock') ? ($this->validated('in_stock')) : true,
            sort: $this->enum('sort', ProductSort::class) ?? ProductSort::SORT,
        );
    }
}
