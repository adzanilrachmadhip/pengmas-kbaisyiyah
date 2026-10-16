<?php

namespace Database\Factories;

use App\Models\EducationHistory;
use App\Models\StaffMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EducationHistory>
 */
class EducationHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'staff_member_id' => StaffMember::factory(),
            'degree' => fake()->randomElement(['S1 Pendidikan Anak Usia Dini', 'S1 Pendidikan Guru PAUD', 'D3 Kebidanan', 'S1 Psikologi']),
            'institution' => fake()->randomElement(['Universitas Negeri Malang', 'Universitas Muhammadiyah Malang', 'Universitas Islam Malang']),
            'year' => (string) fake()->numberBetween(2008, 2022),
        ];
    }
}
