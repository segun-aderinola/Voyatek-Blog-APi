<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run() {
        \App\Models\User::factory(10)->create();
        \App\Models\Blog::factory(5)->create()->each(function ($blog) {
            $blog->posts()->saveMany(\App\Models\Post::factory(10)->make());
        });
    }
}
