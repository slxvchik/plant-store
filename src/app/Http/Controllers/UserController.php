<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\User\CreateUser\CreateUserUseCase;
use App\Application\User\DeleteUser\DeleteUserUseCase;
use App\Application\User\GetUser\GetUserUseCase;
use App\Application\User\GetUsersPage\GetUsersPageUseCase;
use App\Application\User\UpdateUser\UpdateUserUseCase;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class UserController extends Controller
{
    public function __construct(
        private readonly GetUsersPageUseCase $getUsersPageUseCase,
        private readonly GetUserUseCase $getUserUseCase,
        private readonly CreateUserUseCase $createUserUseCase,
        private readonly UpdateUserUseCase $updateUserUseCase,
        private readonly DeleteUserUseCase $deleteUserUseCase,
    ) {}

    public function index(PaginationRequest $request): Response
    {
        $usersPage = $this->getUsersPageUseCase->execute($request->toPageable());

        return Inertia::render('admin/Users', [
            'usersPage' => new PageResponseDto($usersPage, $request->fullUrl()),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->createUserUseCase->execute($request->toDto());

        return redirect()->back()->with(Notification::flash('Пользователь успешно добавлен.'));
    }

    public function show(string $id): Response
    {
        return Inertia::render('admin/UserShow', [
            'user' => $this->getUserUseCase->execute($id),
        ]);
    }

    public function update(UpdateUserRequest $request, string $id): RedirectResponse
    {
        $this->updateUserUseCase->execute($request->toDto($id));

        return redirect()->back()->with(Notification::flash('Пользователь успешно обновлён.'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteUserUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Пользователь успешно удалён.'));
    }
}
