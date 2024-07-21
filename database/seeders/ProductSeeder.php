<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Brand;
use App\Models\User;
use App\Enums\Gender;
use App\Enums\PurchaseType;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch existing categories, brands, and users
        $categories = ProductCategory::pluck('id')->toArray();
        $brands = Brand::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        // Check if we have enough records to create products
        if (count($categories) < 1 || count($brands) < 1 || count($users) < 1) {
            $this->command->error('Not enough categories, brands, or users to seed products.');
            return;
        }

        // Instantiate Faker
        $faker = Faker::create();

        // Create products using random data
        for ($i = 1; $i <= 15; $i++) {
            Product::create([
                'name' => $faker->word,
                'slug' => $faker->unique()->slug,
                'description' => $faker->sentence,
                'category_id' => $faker->randomElement($categories),
                'brand_id' => $faker->randomElement($brands),
                'added_by' => $faker->randomElement($users),
                'gender' => $faker->randomElement(array_column(Gender::cases(), 'value')),
                'purchase_type' => $faker->randomElement(array_column(PurchaseType::cases(), 'value')),
                'is_active' => $faker->randomElement([true,false]),
                'step' => 1,
            ]);
        }
    }
}
