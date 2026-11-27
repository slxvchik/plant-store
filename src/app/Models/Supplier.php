<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\Supplier\SupplierModel as DomainSupplier;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * @property string $id
 * @property string $name
 * @property ?string $phone
 * @property ?string $email
 * @property ?string $address
 * @property ?string $comment
 */
class Supplier extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['id', 'name', 'phone', 'email', 'address', 'comment'];

    #[Override]
    protected function casts(): array
    {
        return ['id' => 'string'];
    }

    public function toDomain(): DomainSupplier
    {
        return DomainSupplier::fromDb(
            id: $this->id,
            name: $this->name,
            phone: $this->phone,
            email: $this->email,
            address: $this->address,
            comment: $this->comment,
        );
    }
}
