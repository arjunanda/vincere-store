<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Traits\DashboardHelpers;
use App\Models\Setting;
use Illuminate\Http\Request;

class WebsiteSettingController extends Controller
{
    use DashboardHelpers;

    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('dashboard.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'web_title'       => 'nullable|string|max:255',
            'web_description' => 'nullable|string',
            'web_keywords'    => 'nullable|string',
            'web_author'      => 'nullable|string|max:255',
            'web_favicon'     => 'nullable|image|mimes:ico,png,jpg,jpeg|max:1024',
            'web_logo'        => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'web_og_image'    => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'web_footer'      => 'nullable|string|max:255',
            'contact_wa'      => 'nullable|string|max:20',
            'contact_ig'      => 'nullable|string|max:255',
            'contact_fb'      => 'nullable|string|max:255',
            'contact_email'   => 'nullable|email|max:255',
        ]);

        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                $path = $this->uploadAndCompressImage($request->file($key), 'settings');
                Setting::updateOrCreate(['key' => $key], ['value' => $path]);
            } else {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        \Illuminate\Support\Facades\Cache::forget('web_settings');

        $this->logActivity('UPDATE_SETTINGS', "Memperbarui pengaturan website");

        return back()->with('success', 'Pengaturan website berhasil diperbarui!');
    }
}
