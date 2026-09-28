<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\SectionContent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_richtext_collection_field_is_sanitized_against_xss(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->postJson('/admin/articles', [
            'title' => 'Artikel Uji Keamanan',
            'excerpt' => 'Ringkasan.',
            'body' => '<p>Halo</p><script>alert(1)</script><img src=x onerror=alert(1)>',
            'published_at' => now()->toDateString(),
        ]);

        $response->assertCreated();
        $body = Article::findOrFail($response->json('data.id'))->body;

        $this->assertStringNotContainsString('<script', $body);
        $this->assertStringNotContainsString('onerror', $body);
        $this->assertStringContainsString('Halo', $body);
    }

    public function test_richtext_single_instance_content_is_sanitized_against_xss(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        SectionContent::query()->create([
            'section' => 'home', 'key' => 'hero_subtitle', 'value' => 'Awal', 'type' => 'richtext',
        ]);

        $response = $this->actingAs($admin)->patchJson('/admin/content/home/hero_subtitle', [
            'value' => '<p>Teks</p><script>alert(document.cookie)</script>',
        ]);

        $response->assertOk();
        $stored = SectionContent::forSection('home')['hero_subtitle'];
        $this->assertStringNotContainsString('<script', $stored);
        $this->assertStringContainsString('Teks', $stored);
    }

    public function test_plain_text_field_is_not_evaluated_as_html_on_output(): void
    {
        // Blade's {{ }} escapes it on render; this asserts the stored value
        // itself is left untouched (plain 'text' fields aren't sanitized —
        // they're not trusted as HTML anywhere, so there's nothing to strip).
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->postJson('/admin/features', [
            'title' => '<script>alert(1)</script>',
            'description' => 'Deskripsi aman.',
        ]);

        $response->assertCreated();
        $this->assertSame('<script>alert(1)</script>', $response->json('data.title'));
    }

    public function test_image_upload_rejects_disallowed_mime_type(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post('/admin/staff', [
            'name' => 'Staf Uji',
            'role' => 'Peran',
            'image' => UploadedFile::fake()->create('payload.php', 10, 'application/x-php'),
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('image');
    }

    public function test_image_upload_rejects_oversized_file(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post('/admin/staff', [
            'name' => 'Staf Uji',
            'role' => 'Peran',
            'image' => UploadedFile::fake()->image('foto.jpg')->size(3000), // > 2048 KB limit
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('image');
    }

    public function test_login_endpoint_is_rate_limited(): void
    {
        // Wrong credentials on every attempt — a successful login would
        // authenticate the test client and the 'guest' route middleware
        // would then redirect every later attempt for an unrelated reason.
        // The outer throttle:10,1 counts every request regardless of the
        // (5-attempt) inner per-email lockout that also fires along the way.
        $last = null;
        for ($i = 0; $i < 11; $i++) {
            $last = $this->post('/login', ['email' => 'nobody@example.com', 'password' => 'wrong']);
        }

        $last->assertStatus(429);
    }

    public function test_contact_form_endpoint_is_rate_limited(): void
    {
        $last = null;
        for ($i = 0; $i < 6; $i++) {
            $last = $this->post('/contact', ['name' => 'Uji', 'phone' => '0812', 'message' => 'Halo']);
        }

        $last->assertStatus(429);
    }

    public function test_admin_route_group_carries_a_throttle_middleware(): void
    {
        $route = collect(Route::getRoutes())->first(fn ($r) => $r->getName() === 'admin.dashboard');

        $hasThrottle = collect($route->gatherMiddleware())->contains(fn ($m) => str_starts_with($m, 'throttle:'));

        $this->assertTrue($hasThrottle, 'admin.dashboard route is missing a throttle middleware.');
    }
}
