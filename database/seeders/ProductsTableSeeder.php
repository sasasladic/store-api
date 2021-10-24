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
//        $product = Product::create(
//            [
//                'name' => [
//                    'en' => 'Multix Shoes',
//                    'de' => 'Multix Shoes'
//                ],
//                'description' => [
//                    'en' => 'Mesh shoes for comfort, ease and modern 3-stripes style.',
//                    'de' => 'Mesh-Schuhe für Komfort, Leichtigkeit und modernen 3-Streifen-Stil.'
//                ],
//                'category_gender_id' => 2,
//                'active' => 1,
//                'created_by' => 1,
//                'updated_by' => 1
//            ]
//        );

//        $product->options()->attach(
//            [
//                [
//                    'option_id' => 1,
//                    'created_by' => 1,
//                    'updated_by' => 1,
//                ],
//                [
//                    'option_id' => 2,
//                    'created_by' => 1,
//                    'updated_by' => 1,
//                ]
//            ]
//        );

        $jacket = Product::create(
            [
                'name' => [
                    'en' => 'Essentials Down Parka',
                    'de' => 'Essentials Down Parka'
                ],
                'description' => [
                    'en' => 'A long down jacket for full-body warmth on the coldest days.',
                    'de' => 'Eine lange Daunenjacke für Ganzkörperwärme an den kältesten Tagen.'
                ],
                'category_gender_id' => 8,
                'active' => 1,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
    }
}
