<?php

namespace Database\Seeders\Products;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        // Seed gym-related categories
        ProductCategory::create([
            'name' => 'Dumbbells',
            'slug' => 'dumbbells',
            'description' => 'Category for dumbbells and weightlifting equipment',
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'Treadmills',
            'slug' => 'treadmills',
            'description' => 'Category for treadmills and cardio equipment',
            'is_active' => true,
        ]);

        ProductCategory::create([
            'name' => 'Resistance Bands',
            'slug' => 'resistance-bands',
            'description' => 'Category for resistance bands and workout accessories',
            'is_active' => true,
        ]);

        // Add more gym-related categories as needed

        $this->command->info('Gym-related product categories seeded successfully!');
    }
}
