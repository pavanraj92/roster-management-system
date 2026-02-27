<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display settings page.
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'website');

        if ($tab == 'social-icons') {
            $socialIcons = Setting::where('group', 'social-icons')->orderBy('key')->get();
            $groupedIcons = [];

            // Reconstruct array of {icon, url} from keys like social_icon_1, social_url_1
            foreach ($socialIcons as $item) {
                if (preg_match('/social_(icon|url)_(\d+)/', $item->key, $matches)) {
                    $type = $matches[1];
                    $index = $matches[2];
                    $groupedIcons[$index][$type] = $item->value;
                }
            }

            $settings['social_icons'] = array_values($groupedIcons);
        } elseif ($tab == 'service-highlights') {
            $highlights = Setting::where('group', 'service-highlights')->orderBy('key')->get();
            $groupedHighlights = [];

            // Reconstruct array of {image, title, sub_title}
            foreach ($highlights as $item) {
                if (preg_match('/service_(image|title|sub_title)_(\d+)/', $item->key, $matches)) {
                    $type = $matches[1];
                    $index = $matches[2];
                    $groupedHighlights[$index][$type] = $item->value;
                }
            }
            $settings['service_highlights'] = array_values($groupedHighlights);
        } else {
            $settings = Setting::where('group', $tab)->pluck('value', 'key')->toArray();

            // Decode JSON values if necessary
            foreach ($settings as $key => $value) {
                if (is_string($value) && (str_starts_with($value, '[') || str_starts_with($value, '{'))) {
                    $decoded = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $settings[$key] = $decoded;
                    }
                }
            }
        }

        return view('admin.settings.index', compact('settings', 'tab'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $group = $request->input('group', 'general');
        $data = $request->except('_token', 'group');

        // Handle File Uploads (Top-level)
        foreach ($request->allFiles() as $key => $file) {
            if (!is_array($file)) {
                $path = $file->store('settings', 'public');
                Setting::set($key, $path, $group);
                unset($data[$key]); // Remove from regular data processing
            }
        }

        // Handle Social Icons specifically if present
        if ($request->has('social_icons')) {
            $socialIcons = $request->input('social_icons');

            // Delete existing social icons to replace them
            Setting::where('group', 'social-icons')->delete();

            foreach ($socialIcons as $index => $item) {
                $iconPath = $item['old_icon'] ?? '';
                $idx = $index + 1;

                // Check for new file upload in this row
                if ($request->hasFile("social_icons.$index.icon")) {
                    $file = $request->file("social_icons.$index.icon");
                    $iconPath = $file->store('settings/social', 'public');
                }

                if ($iconPath || !empty($item['url'])) {
                    Setting::create([
                        'key' => "social_icon_$idx",
                        'value' => $iconPath,
                        'group' => 'social-icons'
                    ]);
                    Setting::create([
                        'key' => "social_url_$idx",
                        'value' => $item['url'] ?? '',
                        'group' => 'social-icons'
                    ]);
                }
            }
            unset($data['social_icons']);
        }

        // Handle Service Highlights specifically
        if ($request->has('service_highlights')) {
            $highlights = $request->input('service_highlights');
            Setting::where('group', 'service-highlights')->delete();

            foreach ($highlights as $index => $item) {
                $imagePath = $item['old_image'] ?? '';
                $idx = $index + 1;

                if ($request->hasFile("service_highlights.$index.image")) {
                    $file = $request->file("service_highlights.$index.image");
                    $imagePath = $file->store('settings/services', 'public');
                }

                if ($imagePath || !empty($item['title']) || !empty($item['sub_title'])) {
                    Setting::create([
                        'key' => "service_image_$idx",
                        'value' => $imagePath,
                        'group' => 'service-highlights'
                    ]);
                    Setting::create([
                        'key' => "service_title_$idx",
                        'value' => $item['title'] ?? '',
                        'group' => 'service-highlights'
                    ]);
                    Setting::create([
                        'key' => "service_sub_title_$idx",
                        'value' => $item['sub_title'] ?? '',
                        'group' => 'service-highlights'
                    ]);
                }
            }
            unset($data['service_highlights']);
        }

        // Handle All Other Regular Data
        foreach ($data as $key => $value) {
            // Encode arrays to JSON (for any other repeaters)
            if (is_array($value)) {
                $value = json_encode(array_values($value));
            }
            Setting::set($key, $value, $group);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
