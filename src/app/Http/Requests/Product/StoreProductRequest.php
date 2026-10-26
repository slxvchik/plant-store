<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use App\Application\Product\CreateProduct\CreateProductRequestDto;

class StoreProductRequest extends ProductRequest
{
    public function toDto(): CreateProductRequestDto
    {
        return new CreateProductRequestDto(...$this->productData());
    }
}
