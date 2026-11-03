<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\Cart\CreateCart\CreateCartUseCase;
use App\Application\Cart\GetUserCart\Dto\Request\GetUserCartRequestDto;
use App\Application\Cart\GetUserCart\GetUserCartUseCase;
use App\Application\Cart\SaveProduct\SaveProductUseCase;
use App\Application\Cart\Shared\Exception\CartNotFoundException;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use App\Http\Requests\Cart\SaveProductToCartRequest;
use App\Notification\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class UserCartController extends Controller
{
    private const string CART_SESSION_KEY = 'cart_id';

    public function __construct(
        private readonly GetUserCartUseCase $getUserCartUseCase,
        private readonly CreateCartUseCase $createCartUseCase,
        private readonly SaveProductUseCase $saveProductUseCase,
        private readonly UuidGeneratorInterface $uuidGenerator,
    ) {}

    public function index(Request $request): Response
    {
        $cart = null;
        $cartId = $request->session()->get(self::CART_SESSION_KEY);

        if ($cartId !== null) {
            try {
                $cart = $this->getUserCartUseCase->execute(
                    new GetUserCartRequestDto($cartId, null)
                );
            } catch (CartNotFoundException) {
                $request->session()->forget(self::CART_SESSION_KEY);
            }
        }

        return Inertia::render('user/Cart', [
            'cart' => $cart,
        ]);
    }

    public function store(SaveProductToCartRequest $request): RedirectResponse
    {
        $cartId = $request->session()->get(self::CART_SESSION_KEY);
        $savedToExistingCart = false;

        if ($cartId !== null) {
            try {
                $this->saveProductUseCase->execute($request->toDto($cartId));
                $savedToExistingCart = true;
            } catch (CartNotFoundException) {
                $request->session()->forget(self::CART_SESSION_KEY);
            }
        }

        if (! $savedToExistingCart) {
            $cartId = $this->createCartUseCase->execute($this->uuidGenerator, null);
            $request->session()->put(self::CART_SESSION_KEY, $cartId);
            $this->saveProductUseCase->execute($request->toDto($cartId));
        }

        return redirect()->back()->with(Notification::flash('Товар добавлен в корзину.'));
    }
}
