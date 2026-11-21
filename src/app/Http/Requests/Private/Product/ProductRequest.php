<?php

declare(strict_types=1);

namespace App\Http\Requests\Private\Product;

use App\Application\Product\Shared\Dto\Request\SaveOfferRequestDto;
use App\Domain\Shared\SortedItem\SortedItem;
use Illuminate\Foundation\Http\FormRequest;

abstract class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'active' => ['required', 'boolean'],
            'alias' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'sort' => ['required', 'integer'],
            'description' => ['sometimes', 'nullable', 'string'],
            'category' => ['sometimes', 'nullable', 'uuid', 'exists:categories,id'],
            'featured' => ['required', 'boolean'],
            'tags' => ['sometimes', 'array'],
            'tags.*' => ['uuid', 'exists:tags,id'],
            'images' => ['sometimes', 'array'],
            'images.*.id' => ['required', 'uuid', 'exists:images,id'],
            'images.*.sort' => ['sometimes', 'integer'],
            'videos' => ['sometimes', 'array'],
            'videos.*.id' => ['required', 'uuid', 'exists:videos,id'],
            'videos.*.sort' => ['sometimes', 'integer'],
            'offers' => ['required', 'array'],
            'offers.*.id' => ['sometimes', 'nullable', 'uuid'],
            'offers.*.active' => ['required', 'boolean'],
            'offers.*.sku' => ['required', 'string', 'max:100'],
            'offers.*.sort' => ['required', 'integer'],
            'offers.*.description' => ['sometimes', 'nullable', 'string'],
            'offers.*.price' => ['required', 'integer', 'min:1'],
            'offers.*.stockQuantity' => ['required', 'integer', 'min:0'],
            'offers.*.images' => ['sometimes', 'array'],
            'offers.*.images.*.id' => ['required', 'uuid', 'exists:images,id'],
            'offers.*.images.*.sort' => ['sometimes', 'integer'],
            'offers.*.videos' => ['sometimes', 'array'],
            'offers.*.videos.*.id' => ['required', 'uuid', 'exists:videos,id'],
            'offers.*.videos.*.sort' => ['sometimes', 'integer'],
        ];
    }

    protected function productData(): array
    {
        $data = $this->validated();

        return [
            'active' => $data['active'],
            'alias' => $data['alias'],
            'sort' => $data['sort'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'categoryId' => $data['category'] ?? null,
            'featured' => $data['featured'],
            'tagIds' => $data['tags'] ?? [],
            'videoIds' => $this->sortedItems($data['videos'] ?? []),
            'imageIds' => $this->sortedItems($data['images'] ?? []),
            'offers' => array_map(
                fn (array $offer): SaveOfferRequestDto => new SaveOfferRequestDto(
                    id: $offer['id'] ?? null,
                    active: $offer['active'],
                    sku: $offer['sku'],
                    sort: $offer['sort'],
                    description: $offer['description'] ?? null,
                    price: $offer['price'],
                    stockQuantity: $offer['stockQuantity'] ?? 0,
                    imageIds: $this->sortedItems($offer['images'] ?? []),
                    videoIds: $this->sortedItems($offer['videos'] ?? []),
                ),
                $data['offers'],
            ),
        ];
    }

    /**
     * @param  array<int, array{id: string, sort?: int}>  $items
     * @return SortedItem[]
     */
    private function sortedItems(array $items): array
    {
        return array_map(
            fn (array $item): SortedItem => new SortedItem(
                id: $item['id'],
                sort: $item['sort'] ?? 500,
            ),
            $items,
        );
    }
}
