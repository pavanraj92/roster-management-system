<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisibilitySetting;
use Illuminate\Http\Request;

class VisibilitySettingController extends Controller
{
    /**
     * Display visibility settings page.
     */
    public function index()
    {
        $settings = VisibilitySetting::pluck('is_visible', 'key')->toArray();
        return view('admin.settings.visibility', compact('settings'));
    }

    /**
     * Update visibility settings.
     */
    public function update(Request $request)
    {
        $data = $request->except('_token');

        $allKeys = [
            'site_name',
            'site_email',
            'site_phone',
            'site_address',
            'footer_text',
            'logo',
            'favicon',
            'hero_title',
            'hero_subtitle',
            'social_icons',
            'service_highlights',
            'main_banner',
            'sub_banner',
            'single_banner',
            'popular_products',
            'featured_categories'
        ];

        foreach ($allKeys as $key) {
            VisibilitySetting::updateOrCreate(
                ['key' => $key],
                ['is_visible' => isset($data[$key])]
            );
        }

        return back()->with('success', 'Visibility settings updated successfully.');
    }
}
