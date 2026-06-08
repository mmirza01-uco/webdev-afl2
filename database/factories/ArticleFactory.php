<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title'       => $title,
            'slug'        => Str::slug($title) . '-' . Str::random(5),
            'content'     => fake()->paragraphs(3, true),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}