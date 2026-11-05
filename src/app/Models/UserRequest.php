<?php

namespace App\Models;

use App\Domain\UserRequest\Model\UserRequest as DomainUserRequest;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasUuids;

    public $incrementing = false;

    public $fillable = ['id', 'formName', 'FIO', 'email', 'phone', 'comment'];

    public function toDomain(): DomainUserRequest
    {
        return DomainUserRequest::fromDb(
            id: $this->id,
            formName: $this->formName,
            FIO: $this->FIO,
            email: $this->email,
            phone: $this->phone,
            comment: $this->comment,
        );
    }
}
