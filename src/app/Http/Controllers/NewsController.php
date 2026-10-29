<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\News\CreateNews\CreateNewsUseCase;
use App\Application\News\DeleteNews\DeleteNewsUseCase;
use App\Application\News\GetNews\GetNewsUseCase;
use App\Application\News\GetNewsPage\GetNewsPageUseCase;
use App\Application\News\UpdateNews\UpdateNewsUseCase;
use App\Http\Requests\News\StoreNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use App\Http\Requests\PaginationRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class NewsController extends Controller
{
    public function __construct(
        private readonly GetNewsPageUseCase $getNewsPageUseCase,
        private readonly GetNewsUseCase $getNewsUseCase,
        private readonly CreateNewsUseCase $createNewsUseCase,
        private readonly UpdateNewsUseCase $updateNewsUseCase,
        private readonly DeleteNewsUseCase $deleteNewsUseCase,
    ) {}

    public function index(PaginationRequest $request): Response
    {
        $newsPage = $this->getNewsPageUseCase->execute($request->toPageable());

        return Inertia::render('admin/News', [
            'newsPage' => new PageResponseDto($newsPage, $request->fullUrl()),
        ]);
    }

    public function store(StoreNewsRequest $request): RedirectResponse
    {
        $this->createNewsUseCase->execute($request->toDto());

        return redirect()->back()->with(Notification::flash('Новость успешно добавлена.'));
    }

    public function show(string $id): Response
    {
        return Inertia::render('admin/NewsShow', [
            'news' => $this->getNewsUseCase->execute($id),
        ]);
    }

    public function update(UpdateNewsRequest $request, string $id): RedirectResponse
    {
        $this->updateNewsUseCase->execute($request->toDto($id));

        return redirect()->back()->with(Notification::flash('Новость успешно обновлена.'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteNewsUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Новость успешно удалена.'));
    }
}
