<?php

declare(strict_types=1);

namespace App\Http\Controllers\Private;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\UserRequest\DeleteUserRequest\DeleteUserRequestUseCase;
use App\Application\UserRequest\GetUserRequests\GetUserRequestsUseCase;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\PaginationRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PrivateUserRequestController extends Controller
{
    public function __construct(
        private readonly GetUserRequestsUseCase $getUserRequestsUseCase,
        private readonly DeleteUserRequestUseCase $deleteUserRequestUseCase,
    ) {}

    public function index(PaginationRequest $request): Response
    {
        $requests = $this->getUserRequestsUseCase->execute($request->toPageable());

        return Inertia::render('admin/UserRequests', [
            'userRequestsPage' => new PageResponseDto($requests, $request->fullUrl()),
        ]);
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteUserRequestUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Заявка пользователя успешно удалена'));
    }
}
