<?php

namespace App\Http\Controllers;

use App\Adapters\Pagination\PageResponseDto;
use App\Application\Category\GetAllCategories\GetAllCategoriesUseCase;
use App\Application\Media\CreateImage\CreateImageRequestDto;
use App\Application\Media\CreateImage\CreateImageUseCase;
use App\Application\Product\CreateProduct\CreateProductRequestDto;
use App\Application\Product\CreateProduct\CreateProductUseCase;
use App\Domain\Media\Model\Media;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\SortedItem\SortedItem;
use App\Notification\Notification;
use App\Notification\NotificationType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use LogicException;
use RuntimeException;
use Throwable;

class ProductController extends Controller
{
    public function __construct(
        private readonly CreateProductUseCase $createProductUseCase,
        private readonly GetAllCategoriesUseCase $getAllCategoriesUseCase,
        private readonly CreateImageUseCase $createImageUseCase,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('admin/products/ProductsIndex', [
            'productsPage' => new PageResponseDto(
                page: Page::empty(),
                url: route('admin.products.index'),
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->getAllCategoriesUseCase->execute();

        return Inertia::render('admin/products/CreateProduct', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws LogicException|RuntimeException
     * @throws Throwable
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $imageIds = [];
            foreach ($request->file('images') as $index => $image) {
                $media = new Media(
                    name: $image->getClientOriginalName(),
                    mimeType: $image->getMimeType(),
                    tmpName: $image->getPathname(),
                    error: $image->getError(),
                    size: $image->getSize(),
                );
                $createImageRequestDto = new CreateImageRequestDto(
                    media: $media,
                    altText: '',
                    titleText: '',
                );
                $createdId = $this->createImageUseCase->execute($createImageRequestDto);
                $imageIds[] = new SortedItem(
                    id: $createdId,
                    sort: $index,
                );
            }
        } catch (Exception $exception) {
            DB::rollBack();

            report($exception);
            return redirect()->back()->with([
                new Notification(
                    'Произошла ошибка при сохранении товара',
                    NotificationType::ERROR,
                ),
            ]);
        }

        return redirect()->back()->with([
            new Notification(
                '',
                NotificationType::SUCCESS,
            ),
        ]);

        $createProductRequestDto = new CreateProductRequestDto(
            active: $request->active,
            alias: $request->alias,
            sort: $request->sort,
            name: $request->name,
            description: $request->description,
            categoryIds: $request->categoryIds,
            tagIds: [],
            videoIds: [],
            imageIds: $imageIds,
            offers: []
        );
        $this->createProductUseCase->execute($createProductRequestDto);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('admin/products/ShowProduct');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('admin/products/EditProduct');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
