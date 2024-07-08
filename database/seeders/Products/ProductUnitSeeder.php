<?php

namespace Database\Seeders\Products;

use Illuminate\Database\Seeder;
use App\Models\ProductUnit;

class ProductUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed some sample data for the ProductUnit model
        ProductUnit::create(['unit_name' => 'Piece']);
        ProductUnit::create(['unit_name' => 'Set']);
        ProductUnit::create(['unit_name' => 'Kilogram']);
        ProductUnit::create(['unit_name' => 'Liter']);
        ProductUnit::create(['unit_name' => 'Meter']);
        ProductUnit::create(['unit_name' => 'Box']);
        ProductUnit::create(['unit_name' => 'Dozen']);
        ProductUnit::create(['unit_name' => 'Gallon']);
        ProductUnit::create(['unit_name' => 'Packet']);
        ProductUnit::create(['unit_name' => 'Gram']);

        // Add 10 more sample records
        ProductUnit::create(['unit_name' => 'Bottle']);
        ProductUnit::create(['unit_name' => 'Roll']);
        ProductUnit::create(['unit_name' => 'Carton']);
        ProductUnit::create(['unit_name' => 'Pair']);
        ProductUnit::create(['unit_name' => 'Pound']);
        ProductUnit::create(['unit_name' => 'Sheet']);
        ProductUnit::create(['unit_name' => 'Can']);
        ProductUnit::create(['unit_name' => 'Bag']);
        ProductUnit::create(['unit_name' => 'Bundle']);
        ProductUnit::create(['unit_name' => 'Ounce']);
    }
}
