<?php

namespace App\Application\Product\GetDetailProduct;

use App\Domain\Shared\Exception\InternalException;

readonly class GetDetailProductRequestDto
{
    /**
     * @throws InternalException
     */
    public function __construct(
        public ?string $id,
        public ?string $alias,
    ) {
        if ($id === null && $alias === null) {
            throw new InternalException('Произошла ошибка при отображении товара.');
        }
    }
}
