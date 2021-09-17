<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class TestSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::find(1);

        $strBuilder = "All products and it's variations \n";
        foreach ($product->variants as $variant) {
            $strBuilder .= "Product: " . $product->name . ' sku: ' . $variant->sku . ' ';
            foreach ($variant->optionValues as $optionValue) {
                $strBuilder .= $optionValue->option->name . ': ' . $optionValue->value . ' ';
            }
            $strBuilder .= ' Price: ' . $variant->price . ' In stock: ' . $variant->in_stock . "\n";
        }
        var_dump($strBuilder);
    }
}
