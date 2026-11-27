<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\User\Model\UserModel;
use App\Domain\User\Repository\UserRepository;
use App\Models\User;
use Override;

class UserRepositoryImpl implements UserRepository
{
    #[Override]
    public function create(UserModel $user): string
    {
        User::create($this->attributes($user));

        return $user->id->value;
    }

    #[Override]
    public function update(UserModel $user): void
    {
        User::findOrFail($user->id->value)->update($this->attributes($user));
    }

    #[Override]
    public function delete(string $id): void
    {
        User::findOrFail($id)->delete();
    }

    #[Override]
    public function findById(string $id): ?UserModel
    {
        return User::find($id)?->toDomain();
    }

    #[Override]
    public function findByIds(array $ids): array
    {
        return User::whereIn('id', $ids)
            ->get()
            ->map(fn (User $user): User => $user->toDomain())
            ->all();
    }

    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        $paginator = User::query()
            ->orderBy('created_at')
            ->paginate(perPage: $pageable->perPage, page: $pageable->page);

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (User $user): User => $user->toDomain(),
        );
    }

    #[Override]
    public function findByPhone(string $phone): ?UserModel
    {
        return User::firstWhere('phone', $phone)?->toDomain();
    }

    #[Override]
    public function findByEmail(string $email): ?UserModel
    {
        return User::firstWhere('email', $email)?->toDomain();
    }

    #[Override]
    public function findByEmailConfirmToken(string $confirmToken): ?UserModel
    {
        return User::firstWhere('email_confirm_token', $confirmToken)?->toDomain();
    }

    /**
     * @return array<string, mixed>
     */
    private function attributes(UserModel $user): array
    {
        $roles = [];
        foreach ($user->roles as $role) {
            $roles[] = $role->value;
        }

        return [
            'id' => $user->id->value,
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
            'email' => $user->email,
            'email_confirmed' => $user->emailConfirmed,
            'email_confirm_token' => $user->getEmailConfirmToken(),
            'phone' => $user->phone,
            'image_id' => $user->imageId,
            'roles' => $roles,
            'password' => $user->getPasswordHashValue(),
        ];
    }
}
