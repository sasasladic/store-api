<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::create(
            [
                'name' => [
                    'en' => 'T-Shirt',
                    'de' => 'Hemd'
                ],
                'description' => [
                    'en' => 'A simple cotton shirt that makes it easy to move and provides you with something to wear when you want to be casual and comfortable.',
                    'de' => 'Einfaches Baumwollhemd, das sich leicht bewegen lässt und dir etwas zum Anziehen bietet, wenn du es lässig und bequem haben möchtest.'
                ],
                'category_id' => 2,
                'active' => 1,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
        $product->options()->attach(
            [
                [
                    'option_id' => 1,
                    'created_by' => 1,
                    'updated_by' => 1,
                ],
                [
                    'option_id' => 2,
                    'created_by' => 1,
                    'updated_by' => 1,
                ]
            ]
        );
    }
}
