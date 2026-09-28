<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ContactMessage;
use App\Models\Feature;
use App\Models\Photo;
use Database\Seeders\EcmsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(EcmsSeeder::class);
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function publicRoutes(): array
    {
        return [
            'home' => ['/'],
            'about' => ['/about'],
            'struktur organisasi' => ['/about/struktur-organisasi'],
            'sumber daya manusia' => ['/about/sumber-daya-manusia'],
            'gallery' => ['/gallery'],
            'artikel index' => ['/artikel'],
            'contact' => ['/contact'],
        ];
    }

    #[DataProvider('publicRoutes')]
    public function test_public_page_renders_with_seeded_content(string $uri): void
    {
        $this->get($uri)->assertOk();
    }

    public function test_home_page_shows_seeded_hero_and_features(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Menumbuhkan Iman, Karakter, dan Kegembiraan Belajar Sejak Usia Dini');
        $response->assertSee('Kurikulum Islami Terpadu');
    }

    public function test_header_nav_has_about_dropdown_and_artikel_not_contact(): void
    {
        $response = $this->get('/');

        $response->assertSee('Struktur Organisasi');
        $response->assertSee('Sumber Daya Manusia');
        $response->assertSee('Artikel');
    }

    public function test_published_article_detail_page_renders(): void
    {
        $article = Article::query()->where('status', 'published')->firstOrFail();

        $this->get("/artikel/{$article->slug}")
            ->assertOk()
            ->assertSee($article->title);
    }

    public function test_draft_article_returns_404(): void
    {
        $article = Article::query()->first();
        $article->update(['status' => 'draft']);

        $this->get("/artikel/{$article->slug}")->assertNotFound();
    }

    public function test_unknown_article_slug_returns_404(): void
    {
        $this->get('/artikel/tidak-ada-artikel-ini')->assertNotFound();
    }

    public function test_draft_photo_is_hidden_from_gallery_page(): void
    {
        $draft = Photo::query()->first();
        $draft->update(['status' => 'draft', 'caption' => 'Foto Rahasia Draft']);

        $this->get('/gallery')->assertDontSee('Foto Rahasia Draft');
    }

    public function test_draft_feature_is_hidden_from_home_page(): void
    {
        $draft = Feature::query()->first();
        $draft->update(['status' => 'draft', 'title' => 'Fitur Rahasia Draft']);

        $this->get('/')->assertDontSee('Fitur Rahasia Draft');
    }

    public function test_contact_form_stores_a_message_and_redirects_back(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Wali Murid',
            'phone' => '0812-0000-0000',
            'message' => 'Saya ingin bertanya soal pendaftaran.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Wali Murid',
            'status' => 'new',
        ]);
    }

    public function test_contact_form_requires_name_phone_and_message(): void
    {
        $response = $this->post('/contact', []);

        $response->assertSessionHasErrors(['name', 'phone', 'message']);
        $this->assertSame(0, ContactMessage::query()->count());
    }

    public function test_login_page_renders(): void
    {
        $this->get('/login')->assertOk();
    }
}
