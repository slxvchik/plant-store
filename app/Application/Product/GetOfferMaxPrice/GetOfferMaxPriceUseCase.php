<?php

namespace App\Application\Product\GetOfferMaxPrice;

interface GetOfferMaxPriceUseCase
{
    public function execute(): ?int;
}
