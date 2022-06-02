<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ReviewPost;
use App\Models\ReviewComment;
use App\Models\Category;
use App\Models\TipPost;
use App\Models\TipComment;
use App\Models\NewsPost;
use App\Models\NewsComment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)->create();

        Category::create([
            'name' => 'FPS',
            'slug' => 'fps'
        ]);

        Category::create([
            'name' => 'RPG',
            'slug' => 'rpg'
        ]);

        Category::create([
            'name' => 'Sport',
            'slug' => 'sport'
        ]);

        Category::create([
            'name' => 'Adventure',
            'slug' => 'adventure'
        ]);

        Category::create([
            'name' => 'Horror',
            'slug' => 'horror'
        ]);

        // Review
        ReviewPost::factory(30)->create();

        ReviewComment::factory(150)->create();

        // Tip
        TipPost::factory(30)->create();

        TipComment::factory(150)->create();

        // News
        NewsPost::factory(30)->create();

        NewsComment::factory(150)->create();
    }
}