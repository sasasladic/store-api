<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::create(
            [
                'name' => 'Size',
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
        Option::create(
            [
                'name' => 'Color',
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
    }
}
