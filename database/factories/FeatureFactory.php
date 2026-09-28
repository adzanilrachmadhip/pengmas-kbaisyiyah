<?php

namespace Database\Factories;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feature>
 */
class FeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'icon' => fake()->randomElement(['book', 'people', 'play', 'shield']),
            'title' => fake()->sentence(3),
            'description' => fake()->sentence(12),
            'sort_order' => fake()->numberBetween(1, 20),
            'status' => 'published',
        ];
    }
}
