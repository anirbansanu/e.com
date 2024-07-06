<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function website()
    {
        $settings = Setting::all();
        return view('admin.settings.website', compact('settings'));
    }
    public function app()
    {
        $settings = Setting::all();
        return view('admin.settings.app', compact('settings'));
    }
    public function update(Request $request)
    {
        $settings = $request->except('_token');

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
