<?php

namespace Database\Seeders;

use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductVariantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productVariant1 = ProductVariant::create(
            [
                'product_id' => 1,
                'sku' => '1LW',
                'price' => 15.50,
                'in_stock' => 30,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
        $productVariant1->optionValues()->attach(
            [
                [
                    'option_value_id' => 1,
                    'created_by' => 1,
                    'updated_by' => 1
                ],
                [
                    'option_value_id' => 4,
                    'created_by' => 1,
                    'updated_by' => 1
                ]
            ]
        );

        $productVariant2 = ProductVariant::create(
            [
                'product_id' => 1,
                'sku' => '1LB',
                'price' => 15.50,
                'in_stock' => 25,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
        $productVariant2->optionValues()->attach(
            [
                [
                    'option_value_id' => 1,
                    'created_by' => 1,
                    'updated_by' => 1
                ],
                [
                    'option_value_id' => 3,
                    'created_by' => 1,
                    'updated_by' => 1
                ]
            ]
        );

        $productVariant3 = ProductVariant::create(
            [
                'product_id' => 1,
                'sku' => '1XLW',
                'price' => 18.50,
                'in_stock' => 20,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
        $productVariant3->optionValues()->attach(
            [
                [
                    'option_value_id' => 2,
                    'created_by' => 1,
                    'updated_by' => 1
                ],
                [
                    'option_value_id' => 4,
                    'created_by' => 1,
                    'updated_by' => 1
                ]
            ]
        );

        $productVariant4 = ProductVariant::create(
            [
                'product_id' => 1,
                'sku' => '1XLB',
                'price' => 18.50,
                'in_stock' => 18,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
        $productVariant4->optionValues()->attach(
            [
                [
                    'option_value_id' => 2,
                    'created_by' => 1,
                    'updated_by' => 1
                ],
                [
                    'option_value_id' => 3,
                    'created_by' => 1,
                    'updated_by' => 1
                ]
            ]
        );

    }
}
