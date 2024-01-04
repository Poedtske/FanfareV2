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
    }
}
