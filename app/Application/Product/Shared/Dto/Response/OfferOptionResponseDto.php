<?php

declare(strict_types=1);

namespace App\Application\Product\Shared\Dto\Response;

use App\Domain\Product\Model\OfferModel;
use JsonSerializable;
use Override;

readonly class OfferOptionResponseDto implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $sku,
    ) {}

    public static function fromDomain(OfferModel $offer): self
    {
        return new self($offer->id->value, $offer->sku ?? '');
    }

    /**
     * @return array{id: string, sku: string, formFactor: ?string, size: ?string}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return ['id' => $this->id, 'sku' => $this->sku];
    }
}
