<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'My Website'],
            ['key' => 'site_description', 'value' => 'This is a description of my website.'],
            ['key' => 'contact_email', 'value' => 'contact@mywebsite.com'],
            ['key' => 'contact_phone', 'value' => '+123456789'],
            ['key' => 'address', 'value' => '123 Main St, Anytown, USA'],
            ['key' => 'facebook', 'value' => 'https://facebook.com/mywebsite'],
            ['key' => 'twitter', 'value' => 'https://twitter.com/mywebsite'],
            ['key' => 'instagram', 'value' => 'https://instagram.com/mywebsite'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
