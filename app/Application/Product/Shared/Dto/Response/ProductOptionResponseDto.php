<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Dto\Response;

use App\Domain\Product\Model\ProductModel;
use JsonSerializable;
use Override;

readonly class ProductOptionResponseDto implements JsonSerializable
{
    /**
     * @param  OfferOptionResponseDto[]  $offers
     */
    public function __construct(public string $id, public string $name, public array $offers) {}

    public static function fromDomain(ProductModel $product): self
    {
        return new self(
            id: $product->id->value,
            name: $product->name,
            offers: array_map(OfferOptionResponseDto::fromDomain(...), $product->getOffers()),
        );
    }

    /**
     * @return array{id: string, name: string, offers: OfferOptionResponseDto[]}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return ['id' => $this->id, 'name' => $this->name, 'offers' => $this->offers];
    }
}
