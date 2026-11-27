<?php

namespace App\Application\Product\GetOfferMinPrice;

interface GetOfferMinPriceUseCase
{
    public function execute(): ?int;
}
