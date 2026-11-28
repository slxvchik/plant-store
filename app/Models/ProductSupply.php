<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\ProductSupply\ProductSupplyModel as DomainProductSupply;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

/**
 * @property string $id
 * @property ?string $supplier_id
 * @property ?string $offer_id
 * @property int $declared_quantity
 * @property int $actual_quantity
 * @property ?int $unit_purchase_price_in_kopecks
 * @property ?int $total_purchase_price_in_kopecks
 * @property string $comment
 * @property bool $mis_graded
 * @property DateTimeImmutable $created_at
 * @property ?DateTimeImmutable $updated_at
 */
class ProductSupply extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'supplier_id',
        'offer_id',
        'declared_quantity',
        'actual_quantity',
        'unit_purchase_price_in_kopecks',
        'total_purchase_price_in_kopecks',
        'comment',
        'mis_graded',
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'declared_quantity' => 'integer',
            'actual_quantity' => 'integer',
            'unit_purchase_price_in_kopecks' => 'integer',
            'total_purchase_price_in_kopecks' => 'integer',
            'mis_graded' => 'boolean',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }

    /**
     * @return HasMany<ProductUnit, $this>
     */
    public function productUnits(): HasMany
    {
        return $this->hasMany(ProductUnit::class);
    }

    public function toDomain(): DomainProductSupply
    {
        $productUnitIds = $this->productUnits()->pluck('id')->map(fn (mixed $id): string => (string) $id)->all();

        return DomainProductSupply::fromDb(
            id: $this->id,
            supplierId: $this->supplier_id,
            offerId: $this->offer_id,
            productUnitIds: $productUnitIds,
            declaredQuantity: $this->declared_quantity,
            actualQuantity: $this->actual_quantity,
            unitPurchasePriceInKopecks: $this->unit_purchase_price_in_kopecks,
            totalPurchasePriceInKopecks: $this->total_purchase_price_in_kopecks,
            comment: $this->comment,
            misGraded: $this->mis_graded,
            createdAt: $this->created_at,
            updatedAt: $this->updated_at,
        );
    }
}
