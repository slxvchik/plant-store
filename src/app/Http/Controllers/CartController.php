<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\Cart\CreateCart\CreateCartUseCase;
use App\Application\Cart\DeleteProduct\DeleteProductUseCase;
use App\Application\Cart\GetUserCart\GetUserCartUseCase;
use App\Application\Cart\SaveProduct\SaveProductUseCase;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Http\Requests\Cart\DeleteProductFromCartRequest;
use App\Http\Requests\Cart\GetUserCartRequest;
use App\Http\Requests\Cart\SaveProductToCartRequest;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class CartController extends Controller
{
    public function __construct(
        private readonly GetUserCartUseCase $getUserCartUseCase,
        private readonly CreateCartUseCase $createCartUseCase,
        private readonly SaveProductUseCase $saveProductUseCase,
        private readonly DeleteProductUseCase $deleteProductUseCase,
    ) {}

    public function index(GetUserCartRequest $request): Response
    {
        return Inertia::render('admin/Carts', [
            'cart' => $request->filled('cartId')
                ? $this->getUserCartUseCase->execute($request->toDto())
                : null,
        ]);
    }

    public function store(StoreCartRequest $request, UuidGeneratorInterface $uuidGenerator): RedirectResponse
    {
        $cartId = $this->createCartUseCase->execute($uuidGenerator, $request->toUserId());

        return redirect()->route('admin.carts.list', ['cartId' => $cartId])
            ->with(Notification::flash('Корзина успешно создана.'));
    }

    public function saveProduct(SaveProductToCartRequest $request, string $cartId): RedirectResponse
    {
        $this->saveProductUseCase->execute($request->toDto($cartId));

        return redirect()->back()->with(Notification::flash('Товар добавлен в корзину.'));
    }

    public function deleteProduct(DeleteProductFromCartRequest $request, string $cartId, string $productId, string $offerId): RedirectResponse
    {
        $this->deleteProductUseCase->execute($request->toDto($cartId, $productId, $offerId));

        return redirect()->back()->with(Notification::flash('Товар удалён из корзины.'));
    }
}
