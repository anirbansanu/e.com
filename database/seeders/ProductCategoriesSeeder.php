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
        
        // Clear existing data without truncating
        ProductCategory::query()->delete();

        // Define product categories with names and descriptions
        $categories = [
            ['name' => 'Electronics', 'description' => 'Devices and gadgets for everyday use.'],
            ['name' => 'Fashion', 'description' => 'Clothing and accessories for men, women, and children.'],
            ['name' => 'Home & Kitchen', 'description' => 'Furniture, decor, and kitchenware.'],
            ['name' => 'Sports & Outdoors', 'description' => 'Equipment and apparel for outdoor activities and sports.'],
            ['name' => 'Beauty & Personal Care', 'description' => 'Skincare, makeup, and personal hygiene products.'],
            ['name' => 'Health & Wellness', 'description' => 'Supplements, fitness equipment, and health products.'],
            ['name' => 'Books', 'description' => 'A wide range of books across various genres.'],
            ['name' => 'Toys & Games', 'description' => 'Toys and games for children of all ages.'],
            ['name' => 'Automotive', 'description' => 'Car accessories and automotive tools.'],
            ['name' => 'Baby Products', 'description' => 'Products for infants and toddlers.'],
            ['name' => 'Pet Supplies', 'description' => 'Food, toys, and accessories for pets.'],
            ['name' => 'Office Supplies', 'description' => 'Stationery, office furniture, and supplies.'],
            ['name' => 'Garden & Outdoor', 'description' => 'Tools, plants, and accessories for gardening.'],
            ['name' => 'Music & Instruments', 'description' => 'Musical instruments and accessories.'],
            ['name' => 'Movies & TV', 'description' => 'DVDs, Blu-rays, and streaming options for movies and TV shows.'],
            ['name' => 'Grocery', 'description' => 'Food items, beverages, and household essentials.'],
            ['name' => 'Jewelry', 'description' => 'Fine jewelry and fashion accessories.'],
            ['name' => 'Handmade', 'description' => 'Handcrafted items and artisan goods.'],
            ['name' => 'Collectibles', 'description' => 'Collectible items and memorabilia.'],
            ['name' => 'Software', 'description' => 'Software applications and operating systems.'],
        ];

        // Add timestamps and slug to each category
        foreach ($categories as &$category) {
            $category['slug'] = Str::slug($category['name']);
            $category['is_active'] = true; // Assuming all categories are active
            $category['created_at'] = now();
            $category['updated_at'] = now();
        }

        // Insert into database
        ProductCategory::insert($categories);
    }
}
