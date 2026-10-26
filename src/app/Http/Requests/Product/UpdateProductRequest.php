<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use App\Application\Product\UpdateProduct\UpdateProductRequestDto;

class UpdateProductRequest extends ProductRequest
{
    public function toDto(string $id): UpdateProductRequestDto
    {
        return new UpdateProductRequestDto(...['id' => $id, ...$this->productData()]);
    }
}
