<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AdminOrdersTest extends TestCase
{
    use RefreshDatabase;

    private const string USER_ID = '11111111-2222-3333-4444-555555555555';

    private const string ORDER_ID = '22222222-3333-4444-5555-666666666666';

    private const string FAKE_PRODUCT_ID = '44444444-5555-6666-7777-888888888888';

    private const string FAKE_OFFER_ID = '55555555-6666-7777-8888-999999999999';

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('users')->insert([
            'id' => self::USER_ID,
            'first_name' => 'Иван',
            'last_name' => null,
            'email' => 'ivan@example.com',
            'email_confirmed' => true,
            'email_confirm_token' => null,
            'phone' => '+79999999999',
            'image_id' => null,
            'roles' => json_encode(['USER']),
            'password' => password_hash('Passw0rd!', PASSWORD_DEFAULT),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('warehouses')->insert([
            'id' => '66666666-7777-8888-9999-000000000000',
            'address' => 'Москва, ул. Ленина, 1',
            'phone' => '+79999999998',
        ]);
    }

    public function test_index_renders_paginated_orders(): void
    {
        $this->insertOrder(self::ORDER_ID, status: 'Новый');

        $response = $this->get(route('admin.orders.list'));

        $response->assertOk()->assertInertia(fn (Assert $page): Assert => $page
            ->component('admin/Orders')
            ->has('ordersPage.items', 1)
            ->where('ordersPage.items.0.id', self::ORDER_ID)
            ->where('ordersPage.items.0.status', 'Новый')
            ->where('ordersPage.items.0.orderSumInKopecks', 2000)
            ->where('ordersPage.items.0.user.firstName', 'Иван')
            ->where('ordersPage.items.0.orderLineResponseDto.0.productName', 'Товар не найден')
        );
    }

    public function test_show_renders_single_order(): void
    {
        $this->insertOrder(self::ORDER_ID, status: 'В обработке');

        $response = $this->get(route('admin.orders.show', ['id' => self::ORDER_ID]));

        $response->assertOk()->assertInertia(fn (Assert $page): Assert => $page
            ->component('admin/OrderShow')
            ->where('order.id', self::ORDER_ID)
            ->where('order.status', 'В обработке')
            ->where('order.user.email', 'ivan@example.com')
            ->has('order.orderLineResponseDto', 1)
        );
    }

    public function test_show_unknown_order_redirects_with_error(): void
    {
        $response = $this->get(route('admin.orders.show', [
            'id' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]));

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
    }

    public function test_store_requires_existing_user(): void
    {
        $response = $this->post(route('admin.orders.store'), []);

        $response->assertSessionHasErrors(['userId']);

        $response = $this->post(route('admin.orders.store'), [
            'userId' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]);

        $response->assertSessionHasErrors(['userId']);
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_store_fails_when_user_has_no_cart(): void
    {
        $response = $this->post(route('admin.orders.store'), [
            'userId' => self::USER_ID,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_store_fails_when_cart_is_empty(): void
    {
        DB::table('carts')->insert([
            'id' => '77777777-8888-9999-0000-111111111111',
            'user_id' => self::USER_ID,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->post(route('admin.orders.store'), [
            'userId' => self::USER_ID,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_take_moves_order_into_work(): void
    {
        $this->insertOrder(self::ORDER_ID, status: 'Новый');

        $response = $this->put(route('admin.orders.take', ['id' => self::ORDER_ID]));

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => self::ORDER_ID,
            'status' => 'В обработке',
        ]);
    }

    public function test_take_unknown_order_redirects_with_error(): void
    {
        $response = $this->put(route('admin.orders.take', [
            'id' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]));

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
    }

    public function test_cancel_and_complete_unknown_order_redirect_with_error(): void
    {
        $response = $this->put(route('admin.orders.cancel', [
            'id' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]));
        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');

        $response = $this->put(route('admin.orders.complete', [
            'id' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]));
        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
    }

    public function test_destroy_deletes_order_with_lines(): void
    {
        $this->insertOrder(self::ORDER_ID);

        $response = $this->delete(route('admin.orders.destroy', ['id' => self::ORDER_ID]));

        $response->assertRedirect();
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_lines', 0);
    }

    public function test_destroy_unknown_order_redirects_with_error(): void
    {
        $response = $this->delete(route('admin.orders.destroy', [
            'id' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]));

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
    }

    private function insertOrder(string $id, string $status = 'Новый'): void
    {
        DB::table('orders')->insert([
            'id' => $id,
            'user_id' => self::USER_ID,
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('order_lines')->insert([
            'order_id' => $id,
            'product_id' => self::FAKE_PRODUCT_ID,
            'product_offer_id' => self::FAKE_OFFER_ID,
            'quantity' => 2,
            'unit_price_in_kopecks' => 1000,
        ]);
    }
}
