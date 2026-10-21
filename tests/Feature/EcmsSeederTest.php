<?php

namespace Tests\Feature;

use App\Models\EducationHistory;
use App\Models\MissionPoint;
use App\Models\SectionContent;
use App\Models\StaffMember;
use App\Models\User;
use Database\Seeders\EcmsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EcmsSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_can_run_twice_without_duplicating_content(): void
    {
        // Each section seeder truncates before inserting, so re-seeding an
        // already-seeded database has to stay clean rather than stack up.
        //
        // NOTE: this suite runs on SQLite (phpunit.xml), where truncate
        // compiles to DELETE. On MySQL, truncating a table referenced by a
        // foreign key is refused outright — that's why EcmsSeeder wraps the
        // run in Schema::withoutForeignKeyConstraints(). This test cannot
        // reproduce that engine difference; it only guards re-runnability.
        $this->seed(EcmsSeeder::class);

        $firstRun = [
            'content' => SectionContent::query()->count(),
            'staff' => StaffMember::query()->count(),
            'education' => EducationHistory::query()->count(),
            'mission' => MissionPoint::query()->count(),
            'users' => User::query()->count(),
        ];

        $this->seed(EcmsSeeder::class);

        $this->assertSame($firstRun['content'], SectionContent::query()->count());
        $this->assertSame($firstRun['staff'], StaffMember::query()->count());
        $this->assertSame($firstRun['education'], EducationHistory::query()->count());
        $this->assertSame($firstRun['mission'], MissionPoint::query()->count());
        $this->assertSame($firstRun['users'], User::query()->count());
    }

    public function test_seeded_education_history_stays_attached_to_its_staff_member(): void
    {
        $this->seed(EcmsSeeder::class);

        StaffMember::query()->with('educationHistories')->get()->each(function (StaffMember $staff) {
            $this->assertNotEmpty(
                $staff->educationHistories,
                "Staff member {$staff->id} lost its education history after seeding."
            );
        });
    }
}
