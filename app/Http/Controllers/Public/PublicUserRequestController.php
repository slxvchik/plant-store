<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Application\UserRequest\SaveFormRequest\SaveFormRequestUseCase;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreCallbackRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;

class PublicUserRequestController extends Controller
{
    public function __construct(
        private readonly SaveFormRequestUseCase $saveFormRequestUseCase,
    ) {}

    public function store(StoreCallbackRequest $request): RedirectResponse
    {
        $this->saveFormRequestUseCase->execute($request->toDto());

        return redirect()->back()->with(Notification::flash('Спасибо за заявку'));
    }
}
