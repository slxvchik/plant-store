<?php

namespace App\Http\Controllers;

use App\Application\Tag\CreateTag\CreateTagRequestDto;
use App\Application\Tag\CreateTag\CreateTagUseCase;
use App\Application\Tag\DeleteTag\DeleteTagUseCase;
use App\Application\Tag\GetTags\GetTagsUseCase;
use App\Application\Tag\UpdateTag\UpdateTagRequestDto;
use App\Application\Tag\UpdateTag\UpdateTagUseCase;
use App\Domain\Shared\Pagination\Pageable;
use App\Enums\NotificationType;
use App\Pagination\PageResponseDto;
use App\ValueObjects\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class TagController extends Controller
{
    public function __construct(
        private readonly GetTagsUseCase $getTagsUseCase,
        private readonly CreateTagUseCase $createTagUseCase,
        private readonly UpdateTagUseCase $updateTagUseCase,
        private readonly DeleteTagUseCase $deleteTagUseCase
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $request->validate([
            'page' => 'nullable|int',
            'perPage' => 'nullable|int',
        ]);
        $pageable = new Pageable(
            page: $request->input('page'),
            perPage: $request->input('perPage'),
        );
        $tagsPage = $this->getTagsUseCase->execute($pageable);
        $pageResponseDto = new PageResponseDto(
            page: $tagsPage,
            url: route('admin.tags.index')
        );

        return Inertia::render('admin/Tags', ['tagsPage' => $pageResponseDto]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([]);
        $createTagRequestDto = new CreateTagRequestDto(
            alias: $request->input('alias'),
            sort: $request->input('sort'),
            name: $request->input('name'),
            active: $request->input('active'),
        );
        $this->createTagUseCase->execute($createTagRequestDto);

        return redirect()->back()->with([
            new Notification(
                message: 'Тег создан.',
                type: NotificationType::SUCCESS
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $updateTagRequestDto = new UpdateTagRequestDto(
            id: $id,
            alias: $request->input('alias'),
            sort: $request->input('sort'),
            name: $request->input('name'),
            active: $request->input('active'),
        );
        $this->updateTagUseCase->execute($updateTagRequestDto);

        return redirect()->back()->with([
            new Notification(
                message: 'Тег обновлён.',
                type: NotificationType::SUCCESS,
            ),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $this->deleteTagUseCase->execute($id);

        return redirect()->back()->with(
            new Notification(
                message: 'Тег удалён.',
                type: NotificationType::SUCCESS,
            )->toArray()
        );
    }
}
