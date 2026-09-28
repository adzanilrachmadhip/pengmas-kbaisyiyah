<?php

namespace Database\Factories;

use App\Models\StaffMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StaffMember>
 */
class StaffMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();

        return [
            'name' => $name,
            'role' => fake()->randomElement(['Kepala KB', 'Pendidik Kelompok A', 'Pendidik Kelompok B']),
            'photo_path' => null,
            'initials' => strtoupper(collect(explode(' ', $name))->map(fn ($n) => $n[0])->take(2)->implode('')),
            'sort_order' => fake()->numberBetween(1, 20),
            'status' => 'published',
        ];
    }
}
