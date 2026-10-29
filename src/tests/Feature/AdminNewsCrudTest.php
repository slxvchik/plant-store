<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AdminNewsCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_renders_news_page(): void
    {
        $this->insertNews('11111111-2222-3333-4444-555555555555', alias: 'news-1', sort: 100);

        $response = $this->get(route('admin.news.list'));

        $response->assertOk()->assertInertia(fn (Assert $page): Assert => $page
            ->component('admin/News')
            ->has('newsPage.items', 1)
            ->where('newsPage.items.0.id', '11111111-2222-3333-4444-555555555555')
            ->where('newsPage.items.0.alias', 'news-1')
        );
    }

    public function test_store_creates_news(): void
    {
        $response = $this->post(route('admin.news.store'), [
            'alias' => 'news-1',
            'sort' => 100,
            'name' => 'Первая новость',
            'active' => true,
            'description' => 'Текст новости',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('news', 1);
        $this->assertDatabaseHas('news', [
            'alias' => 'news-1',
            'sort' => 100,
            'name' => 'Первая новость',
            'active' => true,
            'description' => 'Текст новости',
        ]);
    }

    public function test_store_requires_fields(): void
    {
        $response = $this->post(route('admin.news.store'), []);

        $response->assertSessionHasErrors(['alias', 'sort', 'name', 'active']);
        $this->assertDatabaseCount('news', 0);
    }

    public function test_store_rejects_duplicate_alias(): void
    {
        $this->insertNews('11111111-2222-3333-4444-555555555555', alias: 'news-1');

        $response = $this->post(route('admin.news.store'), [
            'alias' => 'news-1',
            'sort' => 200,
            'name' => 'Дубликат',
            'active' => false,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
        $this->assertDatabaseCount('news', 1);
    }

    public function test_show_renders_single_news(): void
    {
        $id = '11111111-2222-3333-4444-555555555555';
        $this->insertNews($id, name: 'Первая новость', description: 'Текст');

        $response = $this->get(route('admin.news.show', ['id' => $id]));

        $response->assertOk()->assertInertia(fn (Assert $page): Assert => $page
            ->component('admin/NewsShow')
            ->where('news.id', $id)
            ->where('news.name', 'Первая новость')
            ->where('news.description', 'Текст')
        );
    }

    public function test_show_unknown_news_redirects_with_error(): void
    {
        $response = $this->get(route('admin.news.show', [
            'id' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]));

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
    }

    public function test_update_modifies_news(): void
    {
        $id = '11111111-2222-3333-4444-555555555555';
        $this->insertNews($id, name: 'Старое название');

        $response = $this->put(route('admin.news.update', ['id' => $id]), [
            'alias' => 'news-updated',
            'sort' => 300,
            'name' => 'Новое название',
            'active' => false,
            'description' => null,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('news', [
            'id' => $id,
            'alias' => 'news-updated',
            'sort' => 300,
            'name' => 'Новое название',
            'active' => false,
            'description' => null,
        ]);
    }

    public function test_update_unknown_news_redirects_with_error(): void
    {
        $response = $this->put(route('admin.news.update', [
            'id' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]), [
            'alias' => 'news-1',
            'sort' => 100,
            'name' => 'Новость',
            'active' => true,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
    }

    public function test_destroy_deletes_news(): void
    {
        $id = '11111111-2222-3333-4444-555555555555';
        $this->insertNews($id);

        $response = $this->delete(route('admin.news.destroy', ['id' => $id]));

        $response->assertRedirect();
        $this->assertDatabaseCount('news', 0);
    }

    public function test_destroy_unknown_news_redirects_with_error(): void
    {
        $response = $this->delete(route('admin.news.destroy', [
            'id' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]));

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
    }

    private function insertNews(
        string $id,
        string $alias = 'news-1',
        int $sort = 500,
        string $name = 'Новость',
        bool $active = true,
        ?string $description = null,
    ): void {
        DB::table('news')->insert([
            'id' => $id,
            'alias' => $alias,
            'sort' => $sort,
            'name' => $name,
            'active' => $active,
            'description' => $description,
        ]);
    }
}
