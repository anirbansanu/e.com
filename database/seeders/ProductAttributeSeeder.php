<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductAttribute;

class ProductAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = [
            ['name' => 'Color', 'has_unit' => false],
            ['name' => 'Size', 'has_unit' => true],
            ['name' => 'Weight', 'has_unit' => true],
            ['name' => 'Material', 'has_unit' => false],
            ['name' => 'Length', 'has_unit' => true],
            ['name' => 'Width', 'has_unit' => true],
            ['name' => 'Height', 'has_unit' => true],
            ['name' => 'Volume', 'has_unit' => true],
            ['name' => 'Density', 'has_unit' => true],
            ['name' => 'Diameter', 'has_unit' => true],
            ['name' => 'Radius', 'has_unit' => true],
            ['name' => 'Thickness', 'has_unit' => true],
            ['name' => 'Capacity', 'has_unit' => true],
            ['name' => 'Power', 'has_unit' => true],
            ['name' => 'Voltage', 'has_unit' => true],
            ['name' => 'Frequency', 'has_unit' => true],
            ['name' => 'Speed', 'has_unit' => true],
            ['name' => 'Temperature', 'has_unit' => true],
            ['name' => 'Pressure', 'has_unit' => true],
            ['name' => 'Humidity', 'has_unit' => true],
        ];

        foreach ($attributes as $attribute) {
            ProductAttribute::create($attribute);
        }
    }
}
