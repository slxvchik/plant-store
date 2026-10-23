<?php

namespace App\Http\Controllers;

use App\Application\UserRequest\DeleteUserRequest\DeleteUserRequestUseCase;
use App\Application\UserRequest\GetUserRequests\GetUserRequestsUseCase;
use App\Application\UserRequest\SaveFormRequest\SaveFormRequestDto;
use App\Application\UserRequest\SaveFormRequest\SaveFormRequestUseCase;
use App\Domain\Shared\Pagination\Pageable;
use App\Notification\Notification;
use App\Notification\NotificationType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserRequestController extends Controller
{
    public function __construct(
        private readonly SaveFormRequestUseCase $saveFormRequestUseCase,
        private readonly GetUserRequestsUseCase $getUserRequestsUseCase,
        private readonly DeleteUserRequestUseCase $deleteUserRequestUseCase
    ) {}

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fio' => 'required|string',
            'phone' => 'required|string',
        ]);

        $saveFormRequestDto = new SaveFormRequestDto(
            formId: 'callback-form',
            FIO: $request->input('fio'),
            phone: $request->input('phone'),
            comment: $request->input('comment')
        );

        $this->saveFormRequestUseCase->execute($saveFormRequestDto);

        return redirect()->back()->with(
            new Notification(
                'Спасибо за заявку',
                NotificationType::SUCCESS
            )->toArray()
        );
    }

    public function index(Request $request): Response
    {
        $pageable = new Pageable(
            page: $request->input('page', 1),
            perPage: $request->input('perPage', 10)
        );

        $requests = $this->getUserRequestsUseCase->execute($pageable);

        return Inertia::render('admin/UserRequests', ['userRequestsPage' => $requests]);
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteUserRequestUseCase->execute($id);

        return redirect()->back()->with([
            new Notification(
                message: 'Заявка пользователя успешно удалена',
                type: NotificationType::SUCCESS,
            ),
        ]);
    }
}
