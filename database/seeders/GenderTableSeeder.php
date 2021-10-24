<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = [
            [
                'gender' => 'Male',
                'image_path' => 'gender/men.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'gender' => 'Female',
                'image_path' => 'gender/women.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('genders')->insert($genders);
    }
}
