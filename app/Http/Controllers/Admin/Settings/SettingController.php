<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function appIndex()
    {
        $settings = Setting::where('type', 'app')->get();
        return view('admin.settings.app', compact('settings'));
    }

    public function appUpdate(Request $request)
    {
        $data = $request->only('settings');
        // return $data;
        foreach ($data['settings'] as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key, 'type' => 'app'],
                ['value' => $value]
            );
        }
        return redirect()->route('admin.settings.app')->with('success', 'App settings updated successfully.');
    }

    // Website Settings
    public function websiteIndex()
    {
        $settings = Setting::where('type', 'website')->get();
        return view('admin.settings.website', compact('settings'));
    }

    public function websiteUpdate(Request $request)
    {
        $data = $request->only('settings');
        foreach ($data['settings'] as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key, 'type' => 'website'],
                ['value' => $value]
            );
        }
        return redirect()->route('admin.settings.website')->with('success', 'Website settings updated successfully.');
    }
}
