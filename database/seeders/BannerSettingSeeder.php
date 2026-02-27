<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BannerSetting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BannerSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'image' => 'slider-1.png',
                'title' => 'Dont miss amazing grocery deals',
                'sub_title' => 'Sign up for daily newsletter',
                'status' => true,
            ],
            [
                'image' => 'slider-2.png',
                'title' => 'Fresh Products Big Discounts',
                'sub_title' => 'Save upto 50% off on your first order',
                'status' => true,
            ],
            [
                'image' => 'slider-3.png',
                'title' => 'Stay home & get your daily needs from our shop',
                'sub_title' => 'Start Your Daily Shopping with Roster',
                'status' => true,
                'is_single_banner' => true,
            ],
            [
                'image' => 'banner-1.png',
                'title' => 'Everyday Fresh & Clean with Our Products',
                'status' => true,
                'is_sub_banner' => true,
            ],
            [
                'image' => 'banner-2.png',
                'title' => 'Make your Breakfast Healthy and Easy',
                'status' => true,
                'is_sub_banner' => true,
            ],
            [
                'image' => 'banner-3.png',
                'title' => 'The best Products Online',
                'status' => true,
                'is_sub_banner' => true,
            ],
        ];

        foreach ($banners as $banner) {
            $source = public_path('admin/imgs/banners/' . $banner['image']);
            $destination = 'banners/' . $banner['image'];

            // copy file to storage
            if (File::exists($source)) {
                Storage::disk('public')->put($destination, File::get($source));
            }

            $banner['image'] = $destination;
            
            BannerSetting::updateOrCreate(
                ['image' => $destination],
                $banner
            );
        }
    }
}
