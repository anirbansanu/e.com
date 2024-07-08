<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            [
                'name' => 'Nike',
                'description' => 'Leading manufacturer of sportswear and athletic shoes.',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Adidas',
                'description' => 'Global brand specializing in athletic shoes, clothing, and accessories.',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Puma',
                'description' => 'Worldwide sports brand known for athletic and casual footwear, apparel, and accessories.',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Under Armour',
                'description' => 'American sportswear company focusing on performance apparel and accessories.',
                'is_active' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Reebok',
                'description' => 'International brand producing athletic footwear, apparel, and accessories.',
                'is_active' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Levi\'s',
                'description' => 'Iconic brand known for denim jeans and casual apparel.',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Gucci',
                'description' => 'Luxury brand known for high-end fashion and leather goods.',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Louis Vuitton',
                'description' => 'Luxury brand specializing in designer handbags, luggage, and accessories.',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'H&M',
                'description' => 'Swedish multinational clothing retail company.',
                'is_active' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Zara',
                'description' => 'Spanish apparel retailer known for its fast fashion.',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('brands')->insert($brands);
    }
}
