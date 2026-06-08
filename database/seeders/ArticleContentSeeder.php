<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class ArticleContentSeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->count(3)->create();

        $articles = Article::factory()->count(30)->create();

        foreach ($articles as $article) {
            Comment::factory()
                ->count(rand(10, 20))
                ->create(['article_id' => $article->id]);
        }
    }
}