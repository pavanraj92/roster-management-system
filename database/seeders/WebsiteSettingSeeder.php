<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class WebsiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. General Website Settings
        $websiteSettings = [
            'site_name' => 'Roster Management System',
            'site_email' => 'roster@roster.com',
            'site_phone' => '+8566464667',
            'site_address' => '123, church street',
            'footer_text' => 'Roster Management System - All rights reserved.',
        ];

        foreach ($websiteSettings as $key => $value) {
            Setting::set($key, $value, 'website');
        }

        // 2. Home Page Settings (Hero Section)
        $homeSettings = [
            'hero_title' => 'Welcome to Roster Management System',
            'hero_subtitle' => 'Your one-stop roster management destination. Browse our products, create an account, and start managing your roster today!',
        ];

        foreach ($homeSettings as $key => $value) {
            Setting::set($key, $value, 'home');
        }

        // 3. Social Icons
        $this->seedSocialIcons();

        // 4. Logo and Favicon
        $this->seedLogoAndFavicon();

        // 5. Service Highlights
        $this->seedServiceHighlights();
    }

    /**
     * Seed service highlights and copy images if needed.
     */
    private function seedServiceHighlights(): void
    {
        $highlights = [
            [
                'title' => 'Best prices & offers',
                'subtitle' => 'Orders $50 or more',
                'icon' => 'icon-1.svg'
            ],
            [
                'title' => 'Free delivery',
                'subtitle' => '24/7 amazing services',
                'icon' => 'icon-2.svg'
            ],
            [
                'title' => 'Great daily deal',
                'subtitle' => 'When you sign up',
                'icon' => 'icon-3.svg'
            ],
            [
                'title' => 'Wide assortment',
                'subtitle' => 'Mega Discounts',
                'icon' => 'icon-4.svg'
            ],
            [
                'title' => 'Easy returns',
                'subtitle' => 'Within 30 days',
                'icon' => 'icon-5.svg'
            ],
        ];

        $sourcePath = public_path('admin/imgs/theme/icons/');
        $destinationFolder = 'settings/services';

        // Ensure directory exists in public storage
        if (!Storage::disk('public')->exists($destinationFolder)) {
            Storage::disk('public')->makeDirectory($destinationFolder);
        }

        foreach ($highlights as $index => $highlight) {
            $idx = $index + 1;
            $fileName = $highlight['icon'];
            $fullSourcePath = $sourcePath . $fileName;
            $relativeDestPath = $destinationFolder . '/' . $fileName;

            // Copy file from public to storage if it exists in public
            if (File::exists($fullSourcePath)) {
                $fileContent = File::get($fullSourcePath);
                Storage::disk('public')->put($relativeDestPath, $fileContent);
            }

            // Set keys as expected by SettingController/index view
            Setting::set("service_image_$idx", $relativeDestPath, 'service-highlights');
            Setting::set("service_title_$idx", $highlight['title'], 'service-highlights');
            Setting::set("service_sub_title_$idx", $highlight['subtitle'], 'service-highlights');
        }
    }

    /**
     * Seed social icons and copy images if needed.
     */
    private function seedSocialIcons(): void
    {
        $socials = [
            [
                'name' => 'facebook',
                'icon' => 'icon-facebook-white.svg',
                'url' => 'https://facebook.com/roster'
            ],
            [
                'name' => 'twitter',
                'icon' => 'icon-twitter-white.svg',
                'url' => 'https://twitter.com/roster'
            ],
            [
                'name' => 'instagram',
                'icon' => 'icon-instagram-white.svg',
                'url' => 'https://instagram.com/roster'
            ],
        ];

        $sourcePath = public_path('admin/imgs/theme/icons/');
        $destinationFolder = 'settings/social';

        // Ensure directory exists in public storage
        if (!Storage::disk('public')->exists($destinationFolder)) {
            Storage::disk('public')->makeDirectory($destinationFolder);
        }

        foreach ($socials as $index => $social) {
            $idx = $index + 1;
            $fileName = $social['icon'];
            $fullSourcePath = $sourcePath . $fileName;
            $relativeDestPath = $destinationFolder . '/' . $fileName;

            // Copy file from public to storage if it exists in public and not in storage
            if (File::exists($fullSourcePath)) {
                $fileContent = File::get($fullSourcePath);
                Storage::disk('public')->put($relativeDestPath, $fileContent);
            }

            // Set keys as expected by SettingController/index view
            Setting::set("social_icon_$idx", $relativeDestPath, 'social-icons');
            Setting::set("social_url_$idx", $social['url'], 'social-icons');
        }
    }

    /**
     * Seed logo and favicon.
     */
    private function seedLogoAndFavicon(): void
    {
        $assets = [
            'logo' => 'logo.png',
            'favicon' => 'favicon.svg',
        ];

        $sourcePath = public_path('admin/imgs/theme/');
        $destinationFolder = 'settings';

        // Ensure directory exists in public storage
        if (!Storage::disk('public')->exists($destinationFolder)) {
            Storage::disk('public')->makeDirectory($destinationFolder);
        }

        foreach ($assets as $key => $fileName) {
            $fullSourcePath = $sourcePath . $fileName;
            $relativeDestPath = $destinationFolder . '/' . $fileName;

            if (File::exists($fullSourcePath)) {
                $fileContent = File::get($fullSourcePath);
                Storage::disk('public')->put($relativeDestPath, $fileContent);
                Setting::set($key, $relativeDestPath, 'website');
            }
        }
    }
}
