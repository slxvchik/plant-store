<?php

namespace App\Http\Controllers;

use App\Application\Category\CreateCategory\CreateCategoryRequestDto;
use App\Application\Category\CreateCategory\CreateCategoryUseCase;
use App\Application\Category\DeleteCategory\DeleteCategoryUseCase;
use App\Application\Category\GetCategories\GetCategoriesUseCase;
use App\Application\Category\UpdateCategory\UpdateCategoryRequestDto;
use App\Application\Category\UpdateCategory\UpdateCategoryUseCase;
use App\Domain\Shared\Pagination\Pageable;
use App\Enums\NotificationType;
use App\Pagination\PageResponseDto;
use App\ValueObjects\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function __construct(
        private readonly GetCategoriesUseCase $getCategoriesUserCase,
        private readonly CreateCategoryUseCase $createCategoryUseCase,
        private readonly UpdateCategoryUseCase $updateCategoryUseCase,
        private readonly DeleteCategoryUseCase $deleteCategoryUseCase
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

        $tagsPage = $this->getCategoriesUserCase->execute($pageable);

        $pageResponseDto = new PageResponseDto(
            page: $tagsPage,
            url: route('admin.categories.index')
        );

        return Inertia::render('admin/Categories', ['categoriesPage' => $pageResponseDto]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $createTagRequestDto = new CreateCategoryRequestDto(
            alias: $request->input('alias'),
            sort: $request->input('sort'),
            name: $request->input('name'),
            active: $request->input('active'),
        );
        $this->createCategoryUseCase->execute($createTagRequestDto);

        return redirect()->back()->with([
            new Notification(
                message: 'Категория создана.',
                type: NotificationType::SUCCESS
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $updateTagRequestDto = new UpdateCategoryRequestDto(
            id: $id,
            alias: $request->input('alias'),
            sort: $request->input('sort'),
            name: $request->input('name'),
            active: $request->input('active'),
        );
        $this->updateCategoryUseCase->execute($updateTagRequestDto);

        return redirect()->back()->with([
            new Notification(
                message: 'Категория обновлена.',
                type: NotificationType::SUCCESS
            ),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $this->deleteCategoryUseCase->execute($id);

        return redirect()->back()->with(
            new Notification(
                message: 'Категория удалёна.',
                type: NotificationType::SUCCESS
            )->toArray()
        );
    }
}
