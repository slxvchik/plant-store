<?php

namespace App\Models;

use App\Domain\Tag\Model\Tag as DomainTagModel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasUuids;

    public $incrementing = false;

    public $fillable = ['id', 'alias', 'sort', 'name', 'active'];

    public function toDomain(): DomainTagModel
    {
        return DomainTagModel::fromDb(
            id: $this->id,
            alias: $this->alias,
            sort: $this->sort,
            name: $this->name,
            active: $this->active,
        );
    }
}
