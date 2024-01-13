<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class instrumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $array=array(1,2,3);

        $instruments=array(
       [
           'name' => 'Mib Cornet',
           'img' => 'images/instrumentFotos/cornet.png',
       ],
       [
           'name' => 'Trompet',
           'img' => 'images/instrumentFotos/trompet.png',
       ],
       [
           'name' => 'Bugel',
           'img' => 'images/instrumentFotos/bugel.png',
       ],
       [
           'name' => 'Altohoorn',
           'img' => 'images/instrumentFotos/altohoorn.png',
       ],
       [
           'name' => 'Franse Hoorn',
           'img' => 'images/instrumentFotos/franse hoorn.png',
       ],
       [
           'name' => 'Trombone',
           'img' => 'images/instrumentFotos/trombone.png',
       ],
       [
           'name' => 'Bastrombone',
           'img' => 'images/instrumentFotos/bastrombone.png',
       ],
       [
           'name' => 'Bariton',
           'img' => 'images/instrumentFotos/bariton.png',
       ],
       [
           'name' => 'Euphonium',
           'img' => 'images/instrumentFotos/euphonium.png',
       ],
       [
           'name' => 'Mib Bas',
           'img' => 'images/instrumentFotos/Mib bas.png',
       ],
       [
           'name' => 'Sib Bas',
           'img' => 'images/instrumentFotos/Sib bas.png',
       ],
       [
           'name' => 'Sax Sopraan',
           'img' => 'images/instrumentFotos/sopraansax.png',
       ],
       [
           'name' => 'Sax Alto',
           'img' => 'images/instrumentFotos/altsax.png',
       ],
       [
           'name' => 'Sax Tenor',
           'img' => 'images/instrumentFotos/tenorsax.png',
       ],
       [
           'name' => 'Sax Bariton',
           'img' => 'images/instrumentFotos/saxbariton.png',
       ],
       [
           'name' => 'Drumstel',
           'img' => 'images/instrumentFotos/drumstel.png',
       ],
       [
           'name' => 'Melodisch Slagwerk',
           'img' => 'images/instrumentFotos/melodisch slagwerk.png',
       ],
       [
           'name' => 'Pauken',
           'img' => 'images/instrumentFotos/pauken.png',
       ],
       [
           'name' => 'Percussie',
           'img' => 'images/instrumentFotos/percussie.png',
       ],);

       \App\Models\Instrument::factory()->create(
           $instruments
       );
    }

}
