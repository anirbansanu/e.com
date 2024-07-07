<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'app_version', 'value' => '1.0.0', 'type' => 'app'],
            ['key' => 'app_debug', 'value' => 'true', 'type' => 'app'],
            ['key' => 'app_name', 'value' => 'E.com', 'type' => 'app'],
            ['key' => 'api', 'value' => 'localhost:8000/api/', 'type' => 'app'],
            ['key' => 'contact_email', 'value' => 'contact@mywebsite.com', 'type' => 'app'],

            ['key' => 'website_name', 'value' => 'E.com', 'type' => 'website'],
            ['key' => 'website_version', 'value' => '1.0.0', 'type' => 'website'],
            ['key' => 'website_debug', 'value' => 'true', 'type' => 'website'],
            ['key' => 'website_url', 'value' => 'localhost:8000', 'type' => 'website'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value'],'type' => $setting['type']]);
        }
    }
}
