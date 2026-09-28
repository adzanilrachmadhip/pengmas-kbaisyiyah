<?php

namespace Database\Factories;

use App\Models\DevelopmentAspect;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DevelopmentAspect>
 */
class DevelopmentAspectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(2, true),
            'description' => fake()->sentence(12),
            'sort_order' => fake()->numberBetween(1, 20),
            'status' => 'published',
        ];
    }
}
