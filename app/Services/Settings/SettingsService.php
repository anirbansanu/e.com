<?php

namespace App\Services\Settings;

use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

class SettingsService
{
    public function cacheSettings()
    {
        $settings = Setting::all(['key', 'value'])->pluck('value', 'key')->toArray();
        Cache::put('settings', $settings, 3600);
    }

    public function getSettings()
    {
        return Cache::remember('settings', 3600, function () {
            return Setting::all(['key', 'value'])->pluck('value', 'key')->toArray();
        });
    }
}
