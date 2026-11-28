<?php

namespace App\Decorators;

use App\Application\ProductUnit\CreateProductUnit\CreateProductUnitRequestDto;
use App\Application\ProductUnit\CreateProductUnit\CreateProductUnitUseCase;
use Illuminate\Support\Facades\DB;
use Override;
use Throwable;

readonly class TransactionalCreateProductUnitUseCase implements CreateProductUnitUseCase
{
    public function __construct(
        private CreateProductUnitUseCase $useCase,
    ) {}

    /**
     * @throws Throwable
     */
    #[Override]
    public function execute(CreateProductUnitRequestDto $requestDto): string
    {
        return DB::transaction(function () use ($requestDto) {
            return $this->useCase->execute($requestDto);
        });
    }
}
