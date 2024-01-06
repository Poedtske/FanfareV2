<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@ehb.be',
            'password'=>'Password!321',
            'birthday'=>'1111-11-11',
            'aboutme'=>"i'm an admin",
            'role'=>'admin',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Robbe',
            'email' => 'robbe.poedts@hotmail.be',
            'password'=>'111111111',
            'birthday'=>'1111-11-11',
            'aboutme'=>"i'm a dev",
            'role'=>'admin',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'test',
            'email' => 'test.user@hotmail.be',
            'password'=>'111111111',
            'birthday'=>'1111-11-11',
            'aboutme'=>"i'm a pleb",
        ]);



        \App\Models\Post::factory()->create([
            'title' => 'Concert 11/11/2023',
            'description' => 'The concert was very successful',
        ]);

        \App\Models\Post::factory()->create([
            'title' => 'Concert 11/03/2024',
            'description' => 'doors open at 19:00',
        ]);

        \App\Models\Post::factory(3)->create();

        \App\Models\Category::factory()->create([
            'name' => 'Posts',
        ]);

        \App\Models\Category::factory(12)->create();

        \App\Models\Question::factory()->create([
            'title' => 'How do I make a post',
            'question'=>"i've looked everywhere how to make a post but i can't find it!!!",
            'anwser'=>'Only admins are allowed to make posts',
            'category_id'=>1,
        ]);

        \App\Models\Question::factory(20)->create();

    }
}
