<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\Shared\Uuid\Uuid;
use App\Domain\User\Model\Role;
use App\Domain\User\Model\User as DomainUser;
use Database\Factories\UserFactory;
use DateTimeImmutable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property bool $email_confirmed
 * @property string|null $email_confirm_token
 * @property string $phone
 * @property string|null $image_id
 * @property string[] $roles
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['id', 'first_name', 'last_name', 'email', 'email_confirmed', 'email_confirm_token', 'phone', 'image_id', 'roles', 'password'])]
#[Hidden(['password', 'email_confirm_token', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasUuids, Notifiable;

    public $incrementing = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_confirmed' => 'boolean',
            'roles' => 'array',
        ];
    }

    public function toDomain(): DomainUser
    {
        $roles = [];
        foreach ($this->roles ?? [] as $role) {
            $roles[] = Role::from($role);
        }

        return DomainUser::fromDb(
            id: new Uuid($this->id),
            passwordHash: $this->password,
            firstName: $this->first_name,
            lastName: $this->last_name,
            email: $this->email,
            emailConfirmToken: $this->email_confirm_token,
            emailConfirmed: $this->email_confirmed,
            phone: $this->phone,
            imageId: $this->image_id,
            roles: $roles,
            createdAt: DateTimeImmutable::createFromInterface($this->created_at),
            updatedAt: $this->updated_at !== null ? DateTimeImmutable::createFromInterface($this->updated_at) : null,
        );
    }
}
