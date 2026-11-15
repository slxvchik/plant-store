<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Mapper;

use App\Application\Product\Shared\Dto\Request\SaveOfferRequestDto;
use App\Domain\Product\Model\SaveOffer;
use App\Domain\ProductUnit\Model\ProductStockModel;

final class SaveOfferMapper
{
    /**
     * @param  SaveOfferRequestDto[]  $offerDtos
     * @return SaveOffer[]
     */
    public static function fromDtos(array $offerDtos): array
    {
        return array_map(self::fromDto(...), $offerDtos);
    }

    public static function fromDto(SaveOfferRequestDto $offer): SaveOffer
    {
        return new SaveOffer(
            id: $offer->id,
            active: $offer->active,
            sku: $offer->sku,
            sort: $offer->sort,
            description: $offer->description,
            price: $offer->price,
            stockQuantity: $offer->stockQuantity,
            imageIds: $offer->imageIds,
            videoIds: $offer->videoIds,
        );
    }
}
