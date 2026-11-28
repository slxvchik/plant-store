<?php

declare(strict_types=1);

namespace App\Http\Controllers\Private;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\Tag\CreateTag\CreateTagUseCase;
use App\Application\Tag\DeleteTag\DeleteTagUseCase;
use App\Application\Tag\GetTags\GetTagsUseCase;
use App\Application\Tag\UpdateTag\UpdateTagUseCase;
use App\Http\Controllers\Controller;
use App\Http\Requests\Private\Tag\StoreTagRequest;
use App\Http\Requests\Private\Tag\UpdateTagRequest;
use App\Http\Requests\Public\PaginationRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class PrivateTagController extends Controller
{
    public function __construct(
        private readonly GetTagsUseCase $getTagsUseCase,
        private readonly CreateTagUseCase $createTagUseCase,
        private readonly UpdateTagUseCase $updateTagUseCase,
        private readonly DeleteTagUseCase $deleteTagUseCase,
    ) {}

    public function index(PaginationRequest $request): Response
    {
        $tagsPage = $this->getTagsUseCase->execute($request->toPageable());

        return Inertia::render('admin/Tags', [
            'tagsPage' => new PageResponseDto($tagsPage, $request->fullUrl()),
        ]);
    }

    public function store(StoreTagRequest $request): RedirectResponse
    {
        $this->createTagUseCase->execute($request->toDto());

        return redirect()->back()->with(Notification::flash('Тег создан.'));
    }

    public function update(UpdateTagRequest $request, string $id): RedirectResponse
    {
        $this->updateTagUseCase->execute($request->toDto($id));

        return redirect()->back()->with(Notification::flash('Тег обновлён.'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteTagUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Тег удалён.'));
    }
}
