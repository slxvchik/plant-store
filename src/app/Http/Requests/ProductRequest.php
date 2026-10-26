<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Application\Product\Shared\Dto\Request\SaveOfferRequestDto;
use App\Application\Product\Shared\Dto\Request\SaveStockRequestDto;
use App\Domain\Shared\SortedItem\SortedItem;
use DateTimeImmutable;
use Illuminate\Foundation\Http\FormRequest;

abstract class ProductRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'active' => ['required', 'boolean'],
            'alias' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'sort' => ['required', 'integer'],
            'description' => ['sometimes', 'nullable', 'string'],
            'categories' => ['sometimes', 'array'],
            'categories.*' => ['uuid', 'exists:categories,id'],
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
            'offers.*.formFactor' => ['sometimes', 'nullable', 'string', 'max:512'],
            'offers.*.size' => ['sometimes', 'nullable', 'string', 'max:512'],
            'offers.*.age' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'offers.*.sowingDate' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'offers.*.stocks' => ['sometimes', 'array'],
            'offers.*.stocks.*.warehouseId' => ['required', 'uuid', 'exists:warehouses,id'],
            'offers.*.stocks.*.quantity' => ['required', 'integer', 'min:0'],
            'offers.*.stocks.*.reserved' => ['required', 'integer', 'min:0'],
            'offers.*.images' => ['sometimes', 'array'],
            'offers.*.images.*.id' => ['required', 'uuid', 'exists:images,id'],
            'offers.*.images.*.sort' => ['sometimes', 'integer'],
            'offers.*.videos' => ['sometimes', 'array'],
            'offers.*.videos.*.id' => ['required', 'uuid', 'exists:videos,id'],
            'offers.*.videos.*.sort' => ['sometimes', 'integer'],
        ];
    }

    /**
     * @return array{
     *     active: bool,
     *     alias: string,
     *     sort: int,
     *     name: string,
     *     description: ?string,
     *     categoryIds: string[],
     *     tagIds: string[],
     *     videoIds: SortedItem<string>[],
     *     imageIds: SortedItem<string>[],
     *     offers: SaveOfferRequestDto[]
     * }
     */
    protected function productData(): array
    {
        /** @var array{
         *     active: bool,
         *     alias: string,
         *     name: string,
         *     sort: int,
         *     description?: ?string,
         *     categories?: string[],
         *     tags?: string[],
         *     images?: array<int, array{id: string, sort?: int}>,
         *     videos?: array<int, array{id: string, sort?: int}>,
         *     offers: array<int, array{
         *         id?: ?string,
         *         active: bool,
         *         sku: string,
         *         sort: int,
         *         description?: ?string,
         *         price: int,
         *         stocks?: array<int, array{warehouseId: string, quantity: int, reserved: int}>,
         *         formFactor?: ?string,
         *         size?: ?string,
         *         age?: ?int,
         *         sowingDate?: ?string,
         *         images?: array<int, array{id: string, sort?: int}>,
         *         videos?: array<int, array{id: string, sort?: int}>
         *     }>
         * } $data
         */
        $data = $this->validated();

        return [
            'active' => $data['active'],
            'alias' => $data['alias'],
            'sort' => $data['sort'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'categoryIds' => $data['categories'] ?? [],
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
                    stocks: array_map(
                        fn (array $stock): SaveStockRequestDto => new SaveStockRequestDto(...$stock),
                        $offer['stocks'] ?? [],
                    ),
                    formFactor: $offer['formFactor'] ?? null,
                    size: $offer['size'] ?? null,
                    age: $offer['age'] ?? null,
                    sowingDate: isset($offer['sowingDate']) ? new DateTimeImmutable($offer['sowingDate']) : null,
                    imageIds: $this->sortedItems($offer['images'] ?? []),
                    videoIds: $this->sortedItems($offer['videos'] ?? []),
                ),
                $data['offers'],
            ),
        ];
    }

    /**
     * @param  array<int, array{id: string, sort?: int}>  $items
     * @return SortedItem<string>[]
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
