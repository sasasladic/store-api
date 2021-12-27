<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create(
            [
                'user_id' => 1,
                'product_variant_id' => 1,
                'status' =>'delivered',
                'quantity' => 10,
                'delivered' => 10,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
        Order::create(
            [
                'user_id' => 1,
                'product_variant_id' => 2,
                'status' =>'delivered',
                'quantity' => 23,
                'delivered' => 20,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
        Order::create(
            [
                'user_id' => 1,
                'product_variant_id' => 3,
                'status' =>'delivered',
                'quantity' => 44,
                'delivered' => 44,
                'created_by' => 1,
                'updated_by' => 1
            ]
        );
    }
}
