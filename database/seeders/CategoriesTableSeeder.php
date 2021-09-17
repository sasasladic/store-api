<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(
            [
                'name' => ['en' => 'Clothes', 'de' => 'Kleider'],
                'description' => ['en' => 'Test desc for Clothes', 'de' => 'Testbeschreibung für Kleidung'],
                'active' => 1
            ]
        );

        Category::create(
            [
                'name' => ['en' => 'Shirts', 'de' => 'Hemden'],
                'description' => ['en' => 'Test desc for Shirts', 'de' => 'Testbeschreibung für Hemden'],
                'parent_id' => 1,
                'active' => 1
            ]
        );

    }
}
