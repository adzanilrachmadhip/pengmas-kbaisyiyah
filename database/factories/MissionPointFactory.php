<?php

namespace Database\Factories;

use App\Models\MissionPoint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MissionPoint>
 */
class MissionPointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => fake()->sentence(10),
            'sort_order' => fake()->numberBetween(1, 20),
            'status' => 'published',
        ];
    }
}
