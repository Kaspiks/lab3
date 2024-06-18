<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::create(['title' => 'Laravel']);
        Category::create(['title' => 'PHP']);
        Category::create(['title' => 'JavaScript']);
        Category::create(['title' => 'Vue.js']);
        Category::create(['title' => 'React']);
        Category::create(['title' => 'CSS']);
        // User::factory(10)->create();

        $laravel_category = Category::where('title', 'Laravel')->first();
        $php_category = Category::where('title', 'PHP')->first();
        $javascript_category = Category::where('title', 'JavaScript')->first();
        $css_category = Category::where('title', 'CSS')->first();

        Post::create([
            'title' => 'Laravel 11 is released',
            'author_id' => User::inRandomOrder()->first()->id,
            'body' => 'Laravel 11 is released and it has many new features.',
            'category_id' => $laravel_category->id
        ]);

        $firstpost = Post::query()->latest()->first();

        $firstpost->comments()->createMany([
            ['body' => 'This is a bad post.', 'author_id' => User::inRandomOrder()->first()->id],
            ['body' => 'I hate Laravel.', 'author_id' => User::inRandomOrder()->first()->id],
            ['body' => 'This is a terrible post.', 'author_id' => User::inRandomOrder()->first()->id],
            ['body' => 'I dislike Laravel.', 'author_id' => User::inRandomOrder()->first()->id]
        ]);

        $post = new Post();
        $post->title = 'PHP 8.4 is in the making';
        $post->author_id = User::inRandomOrder()->first()->id;
        $post->body = 'PHP 8.4 is in the making and it has many new features.';
        $post->category_id = $php_category->id;
        $post->save();

        //we are using model relationship to add comments
        $post->comments()->createMany([
            ['body' => 'This is a great post.', 'author_id' => User::inRandomOrder()->first()->id],
            ['body' => 'I love Laravel.', 'author_id' => User::inRandomOrder()->first()->id],
        ]);


        Post::create([
            'title' => 'JavaScript Strings: 10 Fundamentals You Should Know',
            'author_id' => User::inRandomOrder()->first()->id,
            'body' => 'This article looks at the 10 most important things to know about strings in JavaScript.',
            'category_id' => $javascript_category->id,
        ]);

        Post::create([
            'title' => 'It Rocks: The best language ever is javascript',
            'author_id' => User::inRandomOrder()->first()->id,
            'body' => 'rand info.',
            'category_id' => $javascript_category->id,
        ]);


        Post::create([
            'title' => 'Why UI designers should understand Flexbox and CSS Grid',
            'author_id' => User::inRandomOrder()->first()->id,
            'body' => 'Most designers are familiar with responsive design, a column-based layout approach with fixed breakpoints to cover all screen sizes.',
            'category_id' => $css_category->id,
        ]);

        $javascript_post = Post::where('title', 'JavaScript Strings: 10 Fundamentals You Should Know')->first();
        $css_post = Post::where('title', 'Why UI designers should understand Flexbox and CSS Grid')->first();

        Comment::create([
            'body' => 'I have never heard of this, thank you for the information!',
            'author_id' => User::inRandomOrder()->first()->id,
            'post_id' => $javascript_post->id,
        ]);


        Comment::factory()
            ->count(75)
            ->for($css_post)
            ->for(User::inRandomOrder()->first(), 'author')
            ->create();
    }
}
