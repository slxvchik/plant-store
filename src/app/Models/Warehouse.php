<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Override;

class Warehouse extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
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
}
