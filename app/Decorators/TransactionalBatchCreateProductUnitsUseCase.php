<?php

namespace App\Decorators;

use App\Application\ProductUnit\BatchCreateProductUnits\BatchCreateProductUnitsRequestDto;
use App\Application\ProductUnit\BatchCreateProductUnits\BatchCreateProductUnitsUseCase;
use App\Domain\Shared\Contracts\Transactional;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class TransactionalBatchCreateProductUnitsUseCase implements BatchCreateProductUnitsUseCase
{
    public function __construct(
        private BatchCreateProductUnitsUseCase $useCase,
    ) {}

    /**
     * @throws Throwable
     */
    #[Transactional]
    public function execute(BatchCreateProductUnitsRequestDto $requestDto): array
    {
        return DB::transaction(function () use ($requestDto) {
            return $this->useCase->execute($requestDto);
        });
    }
}
