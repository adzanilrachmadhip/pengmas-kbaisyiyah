<?php

namespace Tests\Feature\Admin;

use App\Models\ContactMessage;
use App\Models\Feature;
use App\Models\SectionContent;
use App\Models\SiteSetting;
use App\Models\StaffMember;
use App\Models\User;
use Database\Seeders\EcmsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminBackendTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_non_admin_users_are_forbidden(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_admin_can_view_dashboard(): void
    {
        // Seed real content (not just an empty schema) so the dashboard's
        // "Terakhir Diperbarui" stat and every collection-manager panel
        // render against realistic data, not all-null edge cases.
        $this->seed(EcmsSeeder::class);
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk();
        $response->assertSee('Kelola Home');
        $response->assertSee('data-collection-manager', false);
    }

    public function test_admin_can_update_single_instance_content(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        SectionContent::query()->create(['section' => 'home', 'key' => 'hero_title', 'value' => 'Old title', 'type' => 'text']);

        $response = $this->actingAs($admin)->patchJson('/admin/content/home/hero_title', [
            'value' => 'New title',
        ]);

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertSame('New title', SectionContent::forSection('home')['hero_title']);
    }

    public function test_admin_can_crud_a_collection_item(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $create = $this->actingAs($admin)->postJson('/admin/features', [
            'title' => 'Fitur Baru',
            'description' => 'Deskripsi fitur baru.',
        ]);
        $create->assertCreated()->assertJson(['success' => true]);
        $id = $create->json('data.id');

        $this->actingAs($admin)->putJson("/admin/features/{$id}", [
            'title' => 'Fitur Diperbarui',
            'description' => 'Deskripsi diperbarui.',
        ])->assertOk();
        $this->assertSame('Fitur Diperbarui', Feature::find($id)->title);

        $this->actingAs($admin)->patchJson("/admin/features/{$id}/status", [
            'status' => 'published',
        ])->assertOk();
        $this->assertSame('published', Feature::find($id)->status);

        $this->actingAs($admin)->deleteJson("/admin/features/{$id}")->assertOk();
        $this->assertModelMissing(Feature::find($id) ?? new Feature(['id' => $id]));
    }

    public function test_admin_can_create_article_with_auto_slug(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->postJson('/admin/articles', [
            'title' => 'Kunjungan Dinas Pendidikan',
            'excerpt' => 'Ringkasan kunjungan.',
            'body' => '<p>Isi artikel.</p>',
            'published_at' => now()->toDateString(),
        ]);

        $response->assertCreated();
        $this->assertSame('kunjungan-dinas-pendidikan', $response->json('data.slug'));
        $this->assertFalse((bool) $response->json('data.is_highlight'));
    }

    public function test_admin_can_upload_and_replace_a_collection_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);

        $create = $this->actingAs($admin)->post('/admin/staff', [
            'name' => 'Ustadzah Fulanah',
            'role' => 'Pendidik Kelompok A',
            'image' => UploadedFile::fake()->image('foto.jpg'),
        ]);
        $create->assertCreated();
        $id = $create->json('data.id');
        $firstPath = StaffMember::find($id)->photo_path;
        $this->assertNotNull($firstPath);
        Storage::disk('public')->assertExists($firstPath);

        $this->actingAs($admin)->post("/admin/staff/{$id}", [
            '_method' => 'PUT',
            'name' => 'Ustadzah Fulanah',
            'role' => 'Pendidik Kelompok A',
            'image' => UploadedFile::fake()->image('foto-baru.jpg'),
        ])->assertOk();

        Storage::disk('public')->assertMissing($firstPath);
        $this->assertNotNull(StaffMember::find($id)->photo_path);
    }

    public function test_admin_can_reorder_a_collection(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $first = Feature::factory()->create(['sort_order' => 1]);
        $second = Feature::factory()->create(['sort_order' => 2]);
        $third = Feature::factory()->create(['sort_order' => 3]);

        $this->actingAs($admin)->postJson('/admin/features/reorder', [
            'ids' => [$third->id, $first->id, $second->id],
        ])->assertOk();

        $this->assertSame(1, $third->fresh()->sort_order);
        $this->assertSame(2, $first->fresh()->sort_order);
        $this->assertSame(3, $second->fresh()->sort_order);
    }

    public function test_reorder_rejects_collections_without_sort_support(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        // 'articles' has has_sort => false in config/ecms.php (ordered by
        // published_at instead).
        $this->actingAs($admin)->postJson('/admin/articles/reorder', [
            'ids' => [1, 2],
        ])->assertStatus(422);
    }

    public function test_unknown_collection_returns_404(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->getJson('/admin/not-a-real-collection')->assertNotFound();
    }

    public function test_admin_can_update_settings(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        SiteSetting::current();

        $this->actingAs($admin)->putJson('/admin/settings', [
            'site_name' => "KB 'Aisyiyah 2 Dau Baru",
            'phone' => '0812-0000-0000',
        ])->assertOk();

        $this->assertSame("KB 'Aisyiyah 2 Dau Baru", SiteSetting::current()->site_name);
    }

    public function test_admin_can_manage_contact_messages(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $message = ContactMessage::query()->create([
            'name' => 'Wali Murid',
            'phone' => '0812xxxx',
            'message' => 'Tanya info pendaftaran',
            'status' => 'new',
        ]);

        $this->actingAs($admin)->getJson('/admin/messages')->assertOk();

        $this->actingAs($admin)->patchJson("/admin/messages/{$message->id}/read")->assertOk();
        $this->assertSame('read', $message->fresh()->status);

        $this->actingAs($admin)->deleteJson("/admin/messages/{$message->id}")->assertOk();
        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }
}
