<?php

namespace App\Repositories;

use App\Adapters\Pagination\PaginationAdapter;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\UserRequest\UserRequestModel as DomainUserRequest;
use App\Domain\UserRequest\UserRequestRepository;
use App\Models\UserRequest;

class UserRequestRepositoryImpl implements UserRequestRepository
{
    public function create(DomainUserRequest $userRequest): string
    {
        UserRequest::create([
            'id' => $userRequest->id->value,
            'formName' => $userRequest->formName,
            'FIO' => $userRequest->FIO,
            'email' => $userRequest->email,
            'phone' => $userRequest->phone,
            'comment' => $userRequest->comment,
        ]);

        return $userRequest->id->value;
    }

    public function delete(string $id): void
    {
        UserRequest::findOrFail($id)->delete();
    }

    public function findById(string $id): ?DomainUserRequest
    {
        $userRequest = UserRequest::find($id);

        return $userRequest?->toDomain();
    }

    /**
     * {@inheritDoc}
     */
    public function findPage(Pageable $pageable): Page
    {
        $paginator = UserRequest::query()->paginate(
            perPage: $pageable->perPage,
            page: $pageable->page,
        );

        return PaginationAdapter::toDomainPage(
            paginator: $paginator,
            mapper: fn (UserRequest $userRequest) => $userRequest->toDomain(),
        );
    }
}
