<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SystemSetting;

class SystemSettingsController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::all()->pluck('value', 'key')->toArray();
        return view('Admin.settings', compact('settings'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            SystemSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
