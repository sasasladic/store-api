<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert(
            [
                [
                    'abbreviation' => 'en',
                    'name' => 'English',
                    'active' => true,
                    'image' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'abbreviation' => 'de',
                    'name' => 'Deutsch',
                    'active' => true,
                    'image' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]
        );
    }
}
