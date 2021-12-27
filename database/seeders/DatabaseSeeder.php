<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguagesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        \App\Models\User::factory(100)->create();
        $this->call(GenderTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(OptionsTableSeeder::class);
        $this->call(OptionValuesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProductVariantsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
//        $this->call(TestSeeders::class);
    }
}
