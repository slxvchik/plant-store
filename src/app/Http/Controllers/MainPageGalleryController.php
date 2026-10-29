<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\MainPageGallery\CreateSlide\CreateSlideUseCase;
use App\Application\MainPageGallery\DeleteSlide\DeleteSlideUseCase;
use App\Application\MainPageGallery\GetSlides\GetSlidesUseCase;
use App\Application\MainPageGallery\UpdateSlide\UpdateSlideUseCase;
use App\Http\Requests\MainPageGallery\StoreMainPageGalleryRequest;
use App\Http\Requests\MainPageGallery\UpdateMainPageGalleryRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class MainPageGalleryController extends Controller
{
    public function __construct(
        private readonly GetSlidesUseCase $getSlidesUseCase,
        private readonly CreateSlideUseCase $createSlideUseCase,
        private readonly UpdateSlideUseCase $updateSlideUseCase,
        private readonly DeleteSlideUseCase $deleteSlideUseCase,
    ) {}

    public function index(): Response
    {
        return Inertia::render('admin/MainPageGallery', [
            'slides' => $this->getSlidesUseCase->execute(),
        ]);
    }

    public function store(StoreMainPageGalleryRequest $request): RedirectResponse
    {
        $this->createSlideUseCase->execute($request->toDto());

        return redirect()->back()->with(Notification::flash('Слайд успешно добавлен.'));
    }

    public function update(UpdateMainPageGalleryRequest $request, string $id): RedirectResponse
    {
        $this->updateSlideUseCase->execute($request->toDto($id));

        return redirect()->back()->with(Notification::flash('Слайд успешно обновлён.'));
    }

    public function destroy(string $id): RedirectResponse
    {
        $this->deleteSlideUseCase->execute($id);

        return redirect()->back()->with(Notification::flash('Слайд успешно удалён.'));
    }
}
