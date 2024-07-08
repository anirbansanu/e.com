<?php

namespace Database\Seeders\Products;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use App\Models\Brand;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run()
    {


        // Create 5 ProductCategory
        $categories = [];

        $categories = ProductCategory::all()->toArray();


        $brands = Brand::all()->toArray();

        // Create 10 Products
        for ($i = 1; $i <= 10; $i++) {
            $category = $categories[array_rand($categories)];
            $brand = $brands[array_rand($brands)];

            $product = Product::create([
                'name' => 'Test Again ' . $i,
                'slug' => Str::slug('Test Again' . $i),
                'description' => 'This is a sample product ' . $i . ' description.',
                'category_id' => $category['id'],
                'brand_id' => $brand['id'],
                'added_by' => null,
                'price' => rand(10, 100),
                'color' => ['Red', 'Blue', 'Green', 'Yellow'][array_rand(['Red', 'Blue', 'Green', 'Yellow'])],
                'weight' => rand(1, 10),
                'gender' => ['men', 'women'][array_rand(['men', 'women'])],
                'feature' => 'Test feature ' . $i,
                'is_active' => 1,
            ]);

            // Attach multiple images to the product
            $imagePaths = [
                'https://source.unsplash.com/user/c_v_r/1900x800',
                'https://source.unsplash.com/user/c_v_r/1900x800',
                'https://source.unsplash.com/user/c_v_r/1900x800',
            ];

            foreach ($imagePaths as $path) {
                $product->addMediaFromUrl($path)->toMediaCollection('image');
            }
        }
    }
}
