<?php

namespace App\Http\Requests;

use App\Application\Product\CreateProduct\CreateProductRequestDto;
use App\Application\Product\Shared\Dto\Request\SaveOfferRequestDto;
use App\Application\Product\Shared\Dto\Request\SaveStockRequestDto;
use App\Application\Product\UpdateProduct\UpdateProductRequestDto;
use DateTimeImmutable;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use ValueError;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'active' => 'required|boolean',
            'alias' => 'required|string',
            'name' => 'required|string',
            'sort' => 'required|integer',
            'offers' => 'required|array',
            'offers.*.active' => 'required|boolean',
            'offers.*.sku' => 'required|string',
            'offers.*.sort' => 'required|integer',
            'offers.*.price' => 'required|integer',
            'offers.*.sowingDate' => 'date',
            'offers.*.stocks.*.warehouseId' => 'required|string',
            'offers.*.stocks.*.quantity' => 'required|integer',
            'offers.*.stocks.*.reserved' => 'required|integer',
        ];
    }

    /**
     * @throws ValueError
     */
    public function getUpdateProductData(): UpdateProductRequestDto
    {
        return new UpdateProductRequestDto(
            id: $this->input('id'),
            active: $this->input('active'),
            alias: $this->input('alias'),
            name: $this->input('name'),
            sort: $this->input('sort'),
            description: $this->input('description'),
            categoryIds: $this->input('categories') ?? [],
            tagIds: [],
            videoIds: [],
            imageIds: $this->input('images'),
            offers: $this->getOffersData(),
        );
    }

    /**
     * @throws ValueError
     */
    public function getCreateProductData(): CreateProductRequestDto
    {
        return new CreateProductRequestDto(
            active: $this->input('active'),
            alias: $this->input('alias'),
            sort: $this->input('sort'),
            name: $this->input('name'),
            description: $this->input('description'),
            categoryIds: $this->input('categories') ?? [],
            tagIds: $this->input('tags') ?? [],
            videoIds: [],
            imageIds: $this->input('images') ?? [],
            offers: $this->getOffersData(),
        );
    }

    /**
     * @return SaveOfferRequestDto[]
     *
     * @throws ValueError
     */
    private function getOffersData(): array
    {
        $offers = $this->input('offers', []);

        $saveOfferRequestDtos = [];
        foreach ($offers as $index => $offer) {
            $saveOfferRequestDtos[] = new SaveOfferRequestDto(
                id: $offer['id'] ?? null,
                active: $offer['active'],
                sku: $offer['sku'],
                sort: $offer['sort'],
                description: $offer['description'],
                price: $offer['price'],
                stocks: $this->getStocksData($index),
                formFactor: $offer['formFactor'],
                size: $offer['size'],
                age: $offer['age'],
                sowingDate: DateTimeImmutable::createFromFormat('Y-m-d', $offer['sowingDate']),
                imageIds: $offer['images'] ?? [],
                videoIds: [],
            );
        }

        return $saveOfferRequestDtos;
    }

    /**
     * @return SaveStockRequestDto[]
     */
    private function getStocksData(int $offerIndex): array
    {
        $stocks = $this->input("offers.$offerIndex.stocks", []);

        $saveStockRequestDtos = [];
        foreach ($stocks as $stock) {
            $saveStockRequestDtos[] = new SaveStockRequestDto(
                warehouseId: $stock['warehouseId'],
                quantity: $stock['quantity'],
                reserved: $stock['reserved'],
            );
        }

        return $saveStockRequestDtos;
    }
}
