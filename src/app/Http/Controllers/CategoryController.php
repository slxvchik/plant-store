<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\Category\CreateCategory\CreateCategoryUseCase;
use App\Application\Category\DeleteCategory\DeleteCategoryUseCase;
use App\Application\Category\GetAllCategories\GetAllCategoriesUseCase;
use App\Application\Category\GetCategoriesPage\GetCategoriesPageUseCase;
use App\Application\Category\UpdateCategory\UpdateCategoryUseCase;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function __construct(
        private readonly GetAllCategoriesUseCase $getAllCategoriesUseCase,
        private readonly GetCategoriesPageUseCase $getCategoriesPageUseCase,
        private readonly CreateCategoryUseCase $createCategoryUseCase,
        private readonly UpdateCategoryUseCase $updateCategoryUseCase,
        private readonly DeleteCategoryUseCase $deleteCategoryUseCase,
    ) {}

    public function index(PaginationRequest $request): Response
    {
        $categoriesPage = $this->getCategoriesPageUseCase->execute($request->toPageable());

        return Inertia::render('admin/Categories', [
            'categoriesPage' => new PageResponseDto($categoriesPage, $request->fullUrl()),
            'categories' => $this->getAllCategoriesUseCase->execute(),
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->createCategoryUseCase->execute($request->toDto());

        return redirect()->back()->with(Notification::flash('Категория создана.'));
    }

    public function update(UpdateCategoryRequest $request, string $id): RedirectResponse
    {
        $this->updateCategoryUseCase->execute($request->toDto($id));

        return redirect()->back()->with(Notification::flash('Категория обновлена.'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteCategoryUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Категория удалена.'));
    }
}
