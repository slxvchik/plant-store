<?php

namespace Tests\Feature;

use App\Application\Cart\CreateCart\CreateCartUseCase;
use App\Domain\Product\Criteria\ProductSearchCriteria;
use App\Domain\Product\Model\Offer;
use App\Domain\Product\Model\Product;
use App\Domain\Product\Model\Stock;
use App\Domain\Product\Repository\ProductRepository;
use App\Domain\Shared\Pagination\Page;
use App\Domain\Shared\Pagination\Pageable;
use App\Domain\Shared\Uuid\UuidGeneratorInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia as Assert;
use LogicException;
use Tests\TestCase;

class UserCartLazyCreationTest extends TestCase
{
    use RefreshDatabase;

    private const string PRODUCT_ID = '9f0b1c2d-3e4f-5a6b-7c8d-9e0f1a2b3c4d';

    private const string OFFER_ID = '8e7a6b5c-4d3e-2f1a-0b9c-8d7e6f5a4b3c';

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('products')->insert([
            'id' => self::PRODUCT_ID,
            'active' => true,
            'sort' => 1,
            'name' => 'Test product',
            'description' => 'test',
        ]);
        DB::table('offers')->insert([
            'id' => self::OFFER_ID,
            'active' => true,
            'sku' => 'SKU-1',
            'sort' => 1,
            'description' => 'test',
            'price' => 1000,
            'form_factor' => 'seeds',
            'size' => 's',
            'age_in_months' => 1,
            'sowing_date' => '2026-01-01',
        ]);

        $product = $this->makeProduct();

        $this->app->instance(ProductRepository::class, new class($product) implements ProductRepository
        {
            public function __construct(private readonly Product $product) {}

            public function create(Product $product): string
            {
                throw new LogicException('Not used.');
            }

            public function update(Product $product): void
            {
                throw new LogicException('Not used.');
            }

            public function delete(string $id): void
            {
                throw new LogicException('Not used.');
            }

            public function findById(string $id): ?Product
            {
                return $id === $this->product->id->value ? $this->product : null;
            }

            public function findByIds(array $ids): array
            {
                return in_array($this->product->id->value, $ids, true) ? [$this->product] : [];
            }

            public function findPage(Pageable $pageable): Page
            {
                throw new LogicException('Not used.');
            }

            public function findByAlias(string $alias): ?Product
            {
                throw new LogicException('Not used.');
            }

            public function search(ProductSearchCriteria $criteria, Pageable $pageable): Page
            {
                throw new LogicException('Not used.');
            }
        });
    }

    public function test_cart_page_visit_does_not_create_cart(): void
    {
        $response = $this->get(route('user.cart.list'));

        $response->assertOk();
        $this->assertDatabaseCount('carts', 0);
        $this->assertNull(session('cart_id'));
    }

    public function test_valid_add_to_cart_creates_cart_and_stores_id_in_session(): void
    {
        $response = $this->post(route('user.cart.store'), $this->validPayload());

        $response->assertRedirect();
        $this->assertDatabaseCount('carts', 1);
        $this->assertDatabaseHas('cart_lines', [
            'product_id' => self::PRODUCT_ID,
            'offer_id' => self::OFFER_ID,
            'quantity' => 2,
        ]);
        $this->assertNotNull(session('cart_id'));
    }

    public function test_subsequent_add_to_cart_reuses_existing_cart(): void
    {
        $this->post(route('user.cart.store'), $this->validPayload(1))->assertRedirect();
        $cartId = session('cart_id');

        $this->post(route('user.cart.store'), $this->validPayload(3))->assertRedirect();

        $this->assertDatabaseCount('carts', 1);
        $this->assertSame($cartId, session('cart_id'));
        $this->assertDatabaseHas('cart_lines', [
            'product_id' => self::PRODUCT_ID,
            'offer_id' => self::OFFER_ID,
            'quantity' => 4,
        ]);
    }

    public function test_cart_page_displays_cart_lines(): void
    {
        $this->post(route('user.cart.store'), $this->validPayload())->assertRedirect();

        $response = $this->get(route('user.cart.list'));

        $response->assertOk()->assertInertia(fn (Assert $page): Assert => $page
            ->component('user/Cart')
            ->where('cart.cartId', session('cart_id'))
            ->has('cart.cartLines', 1)
            ->where('cart.cartLines.0.quantity', 2)
            ->where('cart.cartLines.0.product.productId', self::PRODUCT_ID)
        );
    }

    public function test_stale_session_cart_returns_empty_cart_and_clears_session(): void
    {
        $staleCartId = $this->createThenDeleteCart();

        $response = $this->withSession(['cart_id' => $staleCartId])->get(route('user.cart.list'));

        $response->assertOk()->assertInertia(fn (Assert $page): Assert => $page
            ->component('user/Cart')
            ->where('cart', null)
        );
        $this->assertNull(session('cart_id'));
    }

    public function test_add_to_cart_with_stale_session_cart_creates_new_cart(): void
    {
        $staleCartId = $this->createThenDeleteCart();

        $response = $this->withSession(['cart_id' => $staleCartId])
            ->post(route('user.cart.store'), $this->validPayload());

        $response->assertRedirect();
        $this->assertDatabaseCount('carts', 1);
        $this->assertNotNull(session('cart_id'));
        $this->assertNotSame($staleCartId, session('cart_id'));
    }

    public function test_invalid_add_to_cart_does_not_create_cart(): void
    {
        $response = $this->post(route('user.cart.store'), [
            'productId' => 'not-a-uuid',
            'offerId' => self::OFFER_ID,
            'quantity' => 0,
        ]);

        $response->assertSessionHasErrors(['productId', 'quantity']);
        $this->assertDatabaseCount('carts', 0);
        $this->assertNull(session('cart_id'));
    }

    /**
     * @return array{productId: string, offerId: string, quantity: int}
     */
    private function validPayload(int $quantity = 2): array
    {
        return [
            'productId' => self::PRODUCT_ID,
            'offerId' => self::OFFER_ID,
            'quantity' => $quantity,
        ];
    }

    private function createThenDeleteCart(): string
    {
        $cartId = app(CreateCartUseCase::class)->execute(app(UuidGeneratorInterface::class), null);

        DB::table('cart_lines')->where('cart_id', $cartId)->delete();
        DB::table('carts')->where('id', $cartId)->delete();

        return $cartId;
    }

    private function makeProduct(): Product
    {
        $offer = new Offer(
            id: self::OFFER_ID,
            active: true,
            sku: 'SKU-1',
            sort: 1,
            description: null,
            price: 1000,
            stocks: [new Stock(warehouseId: '9f0b1c2d-3e4f-5a6b-7c8d-9e0f1a2b3c4e', quantity: 10, reserved: 0)],
            formFactor: null,
            size: null,
            age: null,
            sowingDate: null,
            imageIds: [],
            videoIds: [],
        );

        return Product::fromDb(
            id: self::PRODUCT_ID,
            active: true,
            alias: 'test-product',
            sort: 1,
            name: 'Test product',
            description: null,
            categories: [],
            tags: [],
            videoIds: [],
            imageIds: [],
            offers: [self::OFFER_ID => $offer],
        );
    }
}
