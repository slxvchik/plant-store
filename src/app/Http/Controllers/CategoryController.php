<?php

namespace App\Http\Controllers;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\Category\CreateCategory\CreateCategoryRequestDto;
use App\Application\Category\CreateCategory\CreateCategoryUseCase;
use App\Application\Category\DeleteCategory\DeleteCategoryUseCase;
use App\Application\Category\GetAllCategories\GetAllCategoriesUseCase;
use App\Application\Category\GetCategoriesPage\GetCategoriesPageUseCase;
use App\Application\Category\UpdateCategory\UpdateCategoryRequestDto;
use App\Application\Category\UpdateCategory\UpdateCategoryUseCase;
use App\Domain\Shared\Pagination\Pageable;
use App\Notification\Notification;
use App\Notification\NotificationType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function __construct(
        private readonly GetAllCategoriesUseCase  $getAllCategoriesUseCase,
        private readonly GetCategoriesPageUseCase $getCategoriesUserCase,
        private readonly CreateCategoryUseCase    $createCategoryUseCase,
        private readonly UpdateCategoryUseCase    $updateCategoryUseCase,
        private readonly DeleteCategoryUseCase    $deleteCategoryUseCase
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

        $categoriesPage = $this->getCategoriesUserCase->execute($pageable);

        $pageResponseDto = new PageResponseDto(
            page: $categoriesPage,
            url: route('admin.categories.index')
        );

        $allCategories = $this->getAllCategoriesUseCase->execute();

        return Inertia::render('admin/Categories', [
            'categoriesPage' => $pageResponseDto,
            'categories' => $allCategories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $createTagRequestDto = new CreateCategoryRequestDto(
            parentId: $request->input('parentId'),
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
            parentId: $request->input('parentId'),
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
