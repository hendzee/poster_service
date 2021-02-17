<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataCategories = ['CONCERT', 'COMMUNITY', 'FESTIVAL', 'RELIGION'];

        for ($i=0; $i<count($dataCategories); $i++) {
            DB::table('categories')->insert([
                'category_name' => $dataCategories[$i]
            ]);
        }
    }
}
