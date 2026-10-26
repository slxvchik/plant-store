<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Application\Product\CreateProduct\CreateProductRequestDto;

class StoreProductRequest extends ProductRequest
{
    public function toDto(): CreateProductRequestDto
    {
        return new CreateProductRequestDto(...$this->productData());
    }
}
