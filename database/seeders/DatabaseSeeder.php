<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Deliberately NOT using WithoutModelEvents — StaffMember relies on a
    // 'saving' model event to auto-derive 'initials' from 'name', and
    // SectionContent relies on 'saved'/'deleted' events to invalidate its
    // cache. Disabling events here silently skipped both during seeding.

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(EcmsSeeder::class);
    }
}
