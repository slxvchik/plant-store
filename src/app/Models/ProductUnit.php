<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\ProductUnit\ProductUnitModel as DomainProductUnit;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * @property string $id
 * @property ?string $product_supply_id
 * @property ?string $offer_id
 * @property string $warehouse_id
 * @property bool $reserved
 * @property ?DateTimeImmutable $sowing_date
 * @property string $product_unit_status_id
 * @property string $comments
 */
class ProductUnit extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'product_supply_id',
        'offer_id',
        'warehouse_id',
        'reserved',
        'sowing_date',
        'product_unit_status_id',
        'comments',
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'reserved' => 'boolean',
            'sowing_date' => 'immutable_datetime',
        ];
    }

    public function toDomain(): DomainProductUnit
    {
        return DomainProductUnit::fromDb(
            id: $this->id,
            productSupplyId: $this->product_supply_id,
            offerId: $this->offer_id,
            warehouseId: $this->warehouse_id,
            reserved: $this->reserved,
            sowingDate: $this->sowing_date,
            statusHistory: [],
            productUnitStatusId: $this->product_unit_status_id,
            comments: $this->comments,
        );
    }
}
