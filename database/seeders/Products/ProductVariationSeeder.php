<?php

namespace Database\Seeders\Products;

use Illuminate\Database\Seeder;
use App\Models\ProductVariation;

class ProductVariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed some sample data for the ProductVariation model
        ProductVariation::create([
            'name' => 'Color',
            'value' => 'Red',
            'has_unit' => false,
        ]);

        ProductVariation::create([
            'name' => 'Size',
            'value' => 'Medium',
            'has_unit' => true,
        ]);

        // Add more sample data as needed
        ProductVariation::create([
            'name' => 'Weight',
            'value' => '2.5 kg',
            'has_unit' => true,
        ]);

        ProductVariation::create([
            'name' => 'Material',
            'value' => 'Cotton',
            'has_unit' => false,
        ]);

        ProductVariation::create([
            'name' => 'Style',
            'value' => 'Modern',
            'has_unit' => false,
        ]);

        // Add more individual records as needed
        // ...

        // Create a total of 15 records manually
        ProductVariation::create([
            'name' => 'Shape',
            'value' => 'Round',
            'has_unit' => false,
        ]);

        ProductVariation::create([
            'name' => 'Pattern',
            'value' => 'Stripes',
            'has_unit' => false,
        ]);

        ProductVariation::create([
            'name' => 'Capacity',
            'value' => '500 ml',
            'has_unit' => true,
        ]);

        ProductVariation::create([
            'name' => 'Thickness',
            'value' => '2 mm',
            'has_unit' => true,
        ]);

        ProductVariation::create([
            'name' => 'Design',
            'value' => 'Floral',
            'has_unit' => false,
        ]);

        ProductVariation::create([
            'name' => 'Temperature',
            'value' => 'Hot',
            'has_unit' => false,
        ]);

        ProductVariation::create([
            'name' => 'Length',
            'value' => '10 meters',
            'has_unit' => true,
        ]);

        ProductVariation::create([
            'name' => 'Texture',
            'value' => 'Smooth',
            'has_unit' => false,
        ]);

        ProductVariation::create([
            'name' => 'Flavor',
            'value' => 'Vanilla',
            'has_unit' => false,
        ]);

        ProductVariation::create([
            'name' => 'Volume',
            'value' => '1000 ml',
            'has_unit' => true,
        ]);

        ProductVariation::create([
            'name' => 'Resistance',
            'value' => 'Waterproof',
            'has_unit' => false,
        ]);

        ProductVariation::create([
            'name' => 'Voltage',
            'value' => '220V',
            'has_unit' => true,
        ]);
    }
}
