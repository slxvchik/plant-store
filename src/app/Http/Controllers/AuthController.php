<?php

namespace App\Http\Controllers;

use App\Application\User\AuthenticateUser\AuthenticateUserUseCase;
use App\Http\Requests\Login\AuthorizeRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthenticateUserUseCase $authorizeUserUseCase,
    ) {}

    public function showLoginForm(): Response
    {
        return Inertia::render('Login');
    }

    public function authorize(AuthorizeRequest $request): RedirectResponse
    {
        $userId = $this->authorizeUserUseCase->execute($request->toDto());
        if (! empty($userId)) {
            Auth::loginUsingId($userId);
            $request->session()->regenerate();

            return redirect()->route('admin.home')->with(Notification::flash('Вы успешно вошли.'));
        }

        return redirect()->back()->with(Notification::error('Неверный логин или пароль.')->toArray());
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->back()
            ->with(Notification::flash('Вы успешно вышли.'));
    }
}
