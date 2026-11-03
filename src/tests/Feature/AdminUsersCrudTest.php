<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AdminUsersCrudTest extends TestCase
{
    use RefreshDatabase;

    private const string USER_ID = '11111111-2222-3333-4444-555555555555';

    private const string OTHER_ID = '22222222-3333-4444-5555-666666666666';

    public function test_index_renders_users_page(): void
    {
        $this->insertUser(self::USER_ID, email: 'ivan@example.com');

        $response = $this->get(route('admin.users.list'));

        $response->assertOk()->assertInertia(fn (Assert $page): Assert => $page
            ->component('admin/Users')
            ->has('usersPage.items', 1)
            ->where('usersPage.items.0.id', self::USER_ID)
            ->where('usersPage.items.0.email', 'ivan@example.com')
            ->where('usersPage.items.0.roles', ['USER'])
        );
    }

    public function test_index_does_not_expose_sensitive_fields(): void
    {
        $this->insertUser(self::USER_ID);

        $response = $this->get(route('admin.users.list'));

        $response->assertOk()->assertInertia(fn (Assert $page): Assert => $page
            ->missing('usersPage.items.0.password')
            ->missing('usersPage.items.0.emailConfirmToken')
            ->missing('usersPage.items.0.passwordHash')
        );
    }

    public function test_store_creates_user_with_hashed_password(): void
    {
        $response = $this->post(route('admin.users.store'), [
            'firstName' => 'Иван',
            'lastName' => 'Иванов',
            'email' => 'ivan@example.com',
            'phone' => '+79999999999',
            'password' => 'Passw0rd!',
            'emailConfirmed' => true,
            'roles' => ['USER', 'MANAGER'],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'first_name' => 'Иван',
            'last_name' => 'Иванов',
            'email' => 'ivan@example.com',
            'phone' => '+79999999999',
            'email_confirmed' => true,
        ]);

        $user = DB::table('users')->first();
        $this->assertNotEquals('Passw0rd!', $user->password);
        $this->assertTrue(password_verify('Passw0rd!', $user->password));
        $this->assertSame(['USER', 'MANAGER'], json_decode($user->roles, true));
    }

    public function test_store_requires_fields(): void
    {
        $response = $this->post(route('admin.users.store'), []);

        $response->assertSessionHasErrors([
            'firstName', 'email', 'phone', 'password', 'emailConfirmed', 'roles',
        ]);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_store_rejects_duplicate_email(): void
    {
        $this->insertUser(self::USER_ID, email: 'ivan@example.com');

        $response = $this->post(route('admin.users.store'), [
            'firstName' => 'Пётр',
            'email' => 'ivan@example.com',
            'phone' => '+78888888888',
            'password' => 'Passw0rd!',
            'emailConfirmed' => false,
            'roles' => ['USER'],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
        $this->assertDatabaseCount('users', 1);
    }

    public function test_store_rejects_invalid_role(): void
    {
        $response = $this->post(route('admin.users.store'), [
            'firstName' => 'Иван',
            'email' => 'ivan@example.com',
            'phone' => '+79999999999',
            'password' => 'Passw0rd!',
            'emailConfirmed' => false,
            'roles' => ['SUPERUSER'],
        ]);

        $response->assertSessionHasErrors(['roles.0']);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_show_renders_single_user(): void
    {
        $this->insertUser(self::USER_ID, firstName: 'Иван');

        $response = $this->get(route('admin.users.show', ['id' => self::USER_ID]));

        $response->assertOk()->assertInertia(fn (Assert $page): Assert => $page
            ->component('admin/UserShow')
            ->where('user.id', self::USER_ID)
            ->where('user.firstName', 'Иван')
        );
    }

    public function test_show_unknown_user_redirects_with_error(): void
    {
        $response = $this->get(route('admin.users.show', [
            'id' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]));

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
    }

    public function test_update_modifies_user_and_keeps_password_when_omitted(): void
    {
        $this->insertUser(self::USER_ID, email: 'old@example.com');
        $passwordBefore = DB::table('users')->first()->password;

        $response = $this->put(route('admin.users.update', ['id' => self::USER_ID]), [
            'firstName' => 'Иван',
            'lastName' => null,
            'email' => 'new@example.com',
            'phone' => '+79999999999',
            'emailConfirmed' => true,
            'roles' => ['ADMIN'],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => self::USER_ID,
            'email' => 'new@example.com',
            'email_confirmed' => true,
        ]);
        $this->assertSame($passwordBefore, DB::table('users')->first()->password);
        $this->assertSame(['ADMIN'], json_decode(DB::table('users')->first()->roles, true));
    }

    public function test_update_rejects_email_of_another_user(): void
    {
        $this->insertUser(self::USER_ID, email: 'ivan@example.com');
        $this->insertUser(self::OTHER_ID, email: 'peter@example.com');

        $response = $this->put(route('admin.users.update', ['id' => self::OTHER_ID]), [
            'firstName' => 'Пётр',
            'email' => 'ivan@example.com',
            'phone' => '+78888888888',
            'emailConfirmed' => false,
            'roles' => ['USER'],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
        $this->assertDatabaseHas('users', [
            'id' => self::OTHER_ID,
            'email' => 'peter@example.com',
        ]);
    }

    public function test_destroy_deletes_user(): void
    {
        $this->insertUser(self::USER_ID);

        $response = $this->delete(route('admin.users.destroy', ['id' => self::USER_ID]));

        $response->assertRedirect();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_destroy_unknown_user_redirects_with_error(): void
    {
        $response = $this->delete(route('admin.users.destroy', [
            'id' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]));

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
    }

    private function insertUser(
        string $id,
        string $firstName = 'Иван',
        ?string $lastName = null,
        string $email = 'ivan@example.com',
        string $phone = '+79999999999',
    ): void {
        DB::table('users')->insert([
            'id' => $id,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'email_confirmed' => false,
            'email_confirm_token' => null,
            'phone' => $phone,
            'image_id' => null,
            'roles' => json_encode(['USER']),
            'password' => password_hash('Passw0rd!', PASSWORD_DEFAULT),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
