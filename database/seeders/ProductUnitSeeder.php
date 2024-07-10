<?php

namespace Database\Seeders;

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
        $units = [
            ['unit_name' => 'Piece'],
            ['unit_name' => 'Box'],
            ['unit_name' => 'Dozen'],
            ['unit_name' => 'Set'],
            ['unit_name' => 'Meter'],
            ['unit_name' => 'Liter'],
            ['unit_name' => 'Gram'],
            ['unit_name' => 'Kilogram'],
            ['unit_name' => 'Square Meter'],
            ['unit_name' => 'Cubic Meter'],
            ['unit_name' => 'Hour'],
            ['unit_name' => 'Day'],
            ['unit_name' => 'Week'],
            ['unit_name' => 'Month'],
            ['unit_name' => 'Year'],
            ['unit_name' => 'Bottle'],
            ['unit_name' => 'Packet'],
            ['unit_name' => 'Carton'],
            ['unit_name' => 'Roll'],
            ['unit_name' => 'Sheet'],
            ['unit_name' => 'Pair'],
            ['unit_name' => 'Piece'],
            ['unit_name' => 'Liter'],
            ['unit_name' => 'Pound'],
            ['unit_name' => 'Inch'],
            ['unit_name' => 'Centimeter'],
            ['unit_name' => 'Millimeter'],
            ['unit_name' => 'Unit'],
            ['unit_name' => 'Volume'],
        ];

        // Insert data into the database
        foreach ($units as $unit) {
            ProductUnit::create($unit);
        }
    }
}
