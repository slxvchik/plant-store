<?php

namespace App\Models;

use App\Domain\Category\Model\Category as DomainCategoryModel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasUuids;

    public $incrementing = false;

    public $fillable = ['id', 'parent_id', 'alias', 'sort', 'name', 'active'];

    public function toDomain(): DomainCategoryModel
    {
        return DomainCategoryModel::fromDb(
            id: $this->id,
            parentId: $this->parent_id,
            alias: $this->alias,
            sort: $this->sort,
            name: $this->name,
            active: $this->active,
        );
    }
}
