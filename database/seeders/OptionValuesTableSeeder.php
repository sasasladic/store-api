<?php

namespace Database\Seeders;

use App\Models\OptionValue;
use Illuminate\Database\Seeder;

class OptionValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OptionValue::create(
            [
                'option_id' => 1,
                'value' => 'L',
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
        OptionValue::create(
            [
                'option_id' => 1,
                'value' => 'XL',
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
        OptionValue::create(
            [
                'option_id' => 2,
                'value' => 'Black',
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
        OptionValue::create(
            [
                'option_id' => 2,
                'value' => 'White',
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
    }
}
