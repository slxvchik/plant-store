<?php

namespace App\Models;

use App\Domain\Warehouse\Model\Warehouse as DomainWarehouseModel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * @property string $id
 * @property string $address
 * @property string $phone
 */
class Warehouse extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'address',
        'phone'
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'address' => 'string',
            'phone' => 'string'
        ];
    }

    public function toDomain(): DomainWarehouseModel
    {
        return DomainWarehouseModel::fromDb(
            id: $this->id,
            address: $this->address,
            phoneNumber: $this->phone
        );
    }
}
