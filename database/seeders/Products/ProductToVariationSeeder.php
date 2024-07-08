<?php

namespace Database\Seeders\Products;

use Illuminate\Database\Seeder;
use App\Models\ProductToVariation;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductUnit;

class ProductToVariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve random existing records
        $products = Product::inRandomOrder()->limit(20)->get();
        $variations = ProductVariation::inRandomOrder()->limit(20)->get();
        $units = ProductUnit::inRandomOrder()->limit(20)->get();

        // Seed ProductToVariation model with random existing data
        foreach ($products as $product) {
            $variation = $variations->random();
            $unit = $units->random();

            ProductToVariation::create([
                'product_id' => $product->id,
                'variation_id' => $variation->id,
                'unit_id' => $unit->id,
                'item' => 'Sample Item for ' . $product->name,
            ]);
        }
    }
}
