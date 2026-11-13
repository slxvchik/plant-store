<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\User\Model\UserModel;
use App\Domain\User\Repository\UserRepository;
use App\Models\User as UserModel;
use Override;

class UserRepositoryImpl implements UserRepository
{
    #[Override]
    public function create(UserModel $user): string
    {
        UserModel::create($this->attributes($user));

        return $user->id->value;
    }

    #[Override]
    public function update(UserModel $user): void
    {
        UserModel::findOrFail($user->id->value)->update($this->attributes($user));
    }

    #[Override]
    public function delete(string $id): void
    {
        UserModel::findOrFail($id)->delete();
    }

    #[Override]
    public function findById(string $id): ?UserModel
    {
        return UserModel::find($id)?->toDomain();
    }

    #[Override]
    public function findByIds(array $ids): array
    {
        return UserModel::whereIn('id', $ids)
            ->get()
            ->map(fn (UserModel $user): UserModel => $user->toDomain())
            ->all();
    }

    #[Override]
    public function findPage(Pageable $pageable): Page
    {
        $paginator = UserModel::query()
            ->orderBy('created_at')
            ->paginate(perPage: $pageable->perPage, page: $pageable->page);

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (UserModel $user): UserModel => $user->toDomain(),
        );
    }

    #[Override]
    public function findByPhone(string $phone): ?UserModel
    {
        return UserModel::firstWhere('phone', $phone)?->toDomain();
    }

    #[Override]
    public function findByEmail(string $email): ?UserModel
    {
        return UserModel::firstWhere('email', $email)?->toDomain();
    }

    #[Override]
    public function findByEmailConfirmToken(string $confirmToken): ?UserModel
    {
        return UserModel::firstWhere('email_confirm_token', $confirmToken)?->toDomain();
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
