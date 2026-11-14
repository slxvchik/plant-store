<?php

declare(strict_types=1);

namespace App\Application\ProductUnitStatus\Shared\Dto\Response;

use App\Domain\ProductUnitStatus\Model\ProductUnitStatusModel;
use JsonSerializable;
use Override;

readonly class ProductUnitStatusResponseDto implements JsonSerializable
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $comment,
    ) {}

    public static function fromDomain(ProductUnitStatusModel $status): self
    {
        return new self(id: $status->id->value, name: $status->name, comment: $status->comment);
    }

    /**
     * @return array{id: string, name: string, comment: ?string}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return ['id' => $this->id, 'name' => $this->name, 'comment' => $this->comment];
    }
}
