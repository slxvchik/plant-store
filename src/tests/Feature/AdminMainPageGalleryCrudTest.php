<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AdminMainPageGalleryCrudTest extends TestCase
{
    use RefreshDatabase;

    private const string IMAGE_ID = '7f1c1a3e-2b4d-4e5f-8a9b-0c1d2e3f4a5b';

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('images')->insert([
            'id' => self::IMAGE_ID,
            'mime_type' => 'image/png',
            'size_in_bytes' => 100,
        ]);
    }

    public function test_index_renders_slides(): void
    {
        $this->insertSlide('11111111-2222-3333-4444-555555555555', title: 'Первый слайд');

        $response = $this->get(route('admin.main-page.gallery.list'));

        $response->assertOk()->assertInertia(fn (Assert $page): Assert => $page
            ->component('admin/MainPageGallery')
            ->has('slides', 1)
            ->where('slides.0.id', '11111111-2222-3333-4444-555555555555')
            ->where('slides.0.title', 'Первый слайд')
            ->where('slides.0.imageId', self::IMAGE_ID)
        );
    }

    public function test_store_creates_slide(): void
    {
        $response = $this->post(route('admin.main-page.gallery.store'), [
            'sort' => 100,
            'imageId' => self::IMAGE_ID,
            'preTitle' => 'Подзаголовок',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'buttonLink' => '/catalog',
            'buttonText' => 'Перейти',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('main_page_galleries', 1);
        $this->assertDatabaseHas('main_page_galleries', [
            'sort' => 100,
            'image_id' => self::IMAGE_ID,
            'title' => 'Заголовок',
            'button_text' => 'Перейти',
        ]);
    }

    public function test_store_requires_image_and_sort(): void
    {
        $response = $this->post(route('admin.main-page.gallery.store'), []);

        $response->assertSessionHasErrors(['sort', 'imageId']);
        $this->assertDatabaseCount('main_page_galleries', 0);
    }

    public function test_store_rejects_unknown_image(): void
    {
        $response = $this->post(route('admin.main-page.gallery.store'), [
            'sort' => 100,
            'imageId' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]);

        $response->assertSessionHasErrors(['imageId']);
        $this->assertDatabaseCount('main_page_galleries', 0);
    }

    public function test_update_modifies_slide(): void
    {
        $id = '11111111-2222-3333-4444-555555555555';
        $this->insertSlide($id, title: 'Старый заголовок');

        $response = $this->put(route('admin.main-page.gallery.update', ['id' => $id]), [
            'sort' => 200,
            'imageId' => self::IMAGE_ID,
            'title' => 'Новый заголовок',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('main_page_galleries', [
            'id' => $id,
            'sort' => 200,
            'title' => 'Новый заголовок',
        ]);
    }

    public function test_update_keeps_image_when_image_id_is_omitted(): void
    {
        $id = '11111111-2222-3333-4444-555555555555';
        $this->insertSlide($id);

        $response = $this->put(route('admin.main-page.gallery.update', ['id' => $id]), [
            'sort' => 300,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('main_page_galleries', [
            'id' => $id,
            'sort' => 300,
            'image_id' => self::IMAGE_ID,
        ]);
    }

    public function test_update_unknown_slide_redirects_with_error(): void
    {
        $response = $this->put(route('admin.main-page.gallery.update', [
            'id' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]), [
            'sort' => 100,
            'imageId' => self::IMAGE_ID,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
    }

    public function test_destroy_deletes_slide(): void
    {
        $id = '11111111-2222-3333-4444-555555555555';
        $this->insertSlide($id);

        $response = $this->delete(route('admin.main-page.gallery.destroy', ['id' => $id]));

        $response->assertRedirect();
        $this->assertDatabaseCount('main_page_galleries', 0);
    }

    public function test_destroy_unknown_slide_redirects_with_error(): void
    {
        $response = $this->delete(route('admin.main-page.gallery.destroy', [
            'id' => 'aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee',
        ]));

        $response->assertRedirect();
        $response->assertSessionHas('type', 'error');
    }

    private function insertSlide(string $id, int $sort = 500, ?string $title = null): void
    {
        DB::table('main_page_galleries')->insert([
            'id' => $id,
            'sort' => $sort,
            'image_id' => self::IMAGE_ID,
            'title' => $title,
        ]);
    }
}
