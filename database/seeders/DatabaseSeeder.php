<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        $this->call(LanguagesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(OptionsTableSeeder::class);
        $this->call(OptionValuesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProductVariantsTableSeeder::class);
        $this->call(UserOrdersTableSeeder::class);
//        $this->call(TestSeeders::class);
    }
}
