<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\ProductUnitStatus\Model\ProductUnitStatusModel as DomainProductUnitStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * @property string $id
 * @property string $name
 * @property ?string $comment
 */
class ProductUnitStatus extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'name', 'comment'];

    #[Override]
    protected function casts(): array
    {
        return ['id' => 'string'];
    }

    public function toDomain(): DomainProductUnitStatus
    {
        return DomainProductUnitStatus::fromDb(id: $this->id, name: $this->name, comment: $this->comment);
    }
}
