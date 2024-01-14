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
        \App\Models\User::factory(37)->create();

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
            'title' => 'Groot Concert',
            'description' => 'The concert is in xxxx location',
            'cover'=>'images/covers/1.jpg',
            'date'=>'2024-03-24',
            'time'=>'19:00',
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

        \App\Models\Contact::factory(5)->create();

        \App\Models\Question::factory(20)->create();
        $instrumentCategories = [
            ['name' => 'Koperblazers'],
            ['name' => 'Houtblazers'],
            ['name' => 'Slagwerk'],
        ];
        $instrumentsArray=[];
        \App\Models\InstrumentCategory::factory()->createMany(
            $instrumentCategories
        );
        $instrumentsArray=[
            [
                'name' => 'Mib Cornet',
                'img' => 'path/to/cornet.png',
                'instrument_category_id' =>1, // Koperblazers
            ],
            [
                'name' => 'Trompet',
                'img' => 'path/to/trompet.png',
                'instrument_category_id' => 1, // Koperblazers
            ],
            [
                'name' => 'Bugel',
                'img' => 'path/to/bugel.png',
                'instrument_category_id' => 1, // Koperblazers
            ],
            [
                'name' => 'Altohoorn',
                'img' => 'path/to/altohoorn.png',
                'instrument_category_id' => 1, // Koperblazers
            ],
            [
                'name' => 'Franse Hoorn',
                'img' => 'path/to/franse hoorn.png',
                'instrument_category_id' => 1, // Koperblazers
            ],
            [
                'name' => 'Trombone',
                'img' => 'path/to/trombone.png',
                'instrument_category_id' => 1, // Koperblazers
            ],
            [
                'name' => 'Bastrombone',
                'img' => 'path/to/bastrombone.png',
                'instrument_category_id' => 1, // Koperblazers
            ],
            [
                'name' => 'Bariton',
                'img' => 'path/to/bariton.png',
                'instrument_category_id' => 1, // Koperblazers
            ],
            [
                'name' => 'Euphonium',
                'img' => 'path/to/euphonium.png',
                'instrument_category_id' => 1, // Koperblazers
            ],
            [
                'name' => 'Mib Bas',
                'img' => 'path/to/Mib bas.png',
                'instrument_category_id' => 1, // Koperblazers
            ],
            [
                'name' => 'Sib Bas',
                'img' => 'path/to/Sib bas.png',
                'instrument_category_id' => 1, // Koperblazers
            ],
            [
                'name' => 'Sax Sopraan',
                'img' => 'path/to/sopraansax.png',
                'instrument_category_id' => 2, // Houtblazers
            ],
            [
                'name' => 'Sax Alto',
                'img' => 'path/to/altsax.png',
                'instrument_category_id' => 2, // Houtblazers
            ],
            [
                'name' => 'Sax Tenor',
                'img' => 'path/to/tenorsax.png',
                'instrument_category_id' => 2, // Houtblazers
            ],
            [
                'name' => 'Sax Bariton',
                'img' => 'path/to/saxbariton.png',
                'instrument_category_id' => 2, // Houtblazers
            ],
            [
                'name' => 'Drumstel',
                'img' => 'path/to/drumstel.png',
                'instrument_category_id' => 3, // Slagwerk
            ],
            [
                'name' => 'Melodisch Slagwerk',
                'img' => 'path/to/melodisch slagwerk.png',
                'instrument_category_id' => 3, // Slagwerk
            ],
            [
                'name' => 'Pauken',
                'img' => 'path/to/pauken.png',
                'instrument_category_id' => 3, // Slagwerk
            ],
            [
                'name' => 'Percussie',
                'img' => 'path/to/percussie.png',
                'instrument_category_id' => 3, // Slagwerk
            ],
        ];

        \App\Models\Instrument::factory()->createMany(
            $instrumentsArray
        );

        \App\Models\User::all()->each(function($user){
            $instruments=\App\Models\Instrument::all()->random(rand(1,4))->pluck('id');
            $user->instruments()->attach($instruments);
        });

//kud tinder tiran





    }
}
