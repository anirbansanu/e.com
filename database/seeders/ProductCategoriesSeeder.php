<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data
        ProductCategory::truncate();

        // Create 20 product categories
        $categories = [];
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $name = $faker->unique()->word;
            $categories[] = [
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $faker->sentence,
                'is_active' => $faker->boolean(80), // 80% chance of being active
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert into database
        ProductCategory::insert($categories);
    }
}
