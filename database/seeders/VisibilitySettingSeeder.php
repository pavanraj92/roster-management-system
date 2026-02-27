<?php

namespace Database\Seeders;

use App\Models\VisibilitySetting;
use Illuminate\Database\Seeder;

class VisibilitySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $keys = [
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
            'featured_categories',
        ];

        foreach ($keys as $key) {
            VisibilitySetting::updateOrCreate(
                ['key' => $key],
                ['is_visible' => true]
            );
        }
    }
}
