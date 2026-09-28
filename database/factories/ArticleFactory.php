<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1000, 9999),
            'cover_image' => null,
            'excerpt' => fake()->sentence(15),
            'body' => '<p>'.fake()->paragraph().'</p>',
            'published_at' => fake()->dateTimeBetween('-2 months', 'now'),
            'is_highlight' => false,
            'status' => 'published',
        ];
    }
}
