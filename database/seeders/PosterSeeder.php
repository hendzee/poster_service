<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PosterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        $posterImages = [
            'poster1.png', 
            'poster2.png', 
            'poster3.png',
            'poster4.png',
            'poster5.png',
            'poster6.png'
        ];

        for ($i=0; $i<100; $i++) {
            $image = env('APP_URL') . '/storage/app/images/posters/' . $posterImages[rand(0, 5)];

            DB::table('posters')->insert([
                'owner' => 1,
                'title' => $faker->sentence($nbWords = rand(1, 3), $variableNbWords = true) ,
                'description' => $faker->text($maxNbChars = 200),
                'image' => $image,
                'country' => 'ID',
                'price' => rand(5000, 700000),
                'location' => $faker->streetAddress,
                'detail_location' => $faker->address,
                'website' => 'example@gmail.com',
                'facebook' => 'example',
                'instagram' => 'example',
                'twitter' => 'example',
                'category' => rand(1, 3)
            ]);
        }
    }
}
