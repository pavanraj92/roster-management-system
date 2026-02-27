<?php

namespace App\Providers;

use App\Models\BannerSetting;
use App\Models\Category;
use App\Models\Setting;
use App\Models\VisibilitySetting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer(['frontend.partials.footer'], function ($view) {
            $websiteSettings = Setting::query()
                ->select('settings.key', 'settings.value')
                ->where('settings.group', 'website')
                ->join('visibility_settings', 'visibility_settings.key', '=', 'settings.key')
                ->where('visibility_settings.is_visible', true)
                ->pluck('value', 'key')
                ->toArray();

            $bannerSettings = BannerSetting::query()
                ->select('title', 'sub_title', 'image', 'status', 'is_single_banner')
                ->where('status', true)
                ->where('is_single_banner', true)
                ->get()
                ->toArray();


            $socialIcons = Setting::query()
                ->select('settings.key', 'settings.value')
                ->join('visibility_settings', 'visibility_settings.key', '=', 'settings.key')
                ->where('visibility_settings.is_visible', true)
                ->where('group', 'social-icons')
                ->orderBy('key')
                ->get(['key', 'value']);

            $groupedSocialIcons = [];
            foreach ($socialIcons as $item) {
                if (preg_match('/social_(icon|url)_(\d+)/', $item->key, $matches)) {
                    $type = $matches[1];
                    $index = (int) $matches[2];
                    $groupedSocialIcons[$index][$type] = $item->value;
                }
            }

            $serviceHighlights = Setting::query()
                ->where('group', 'service-highlights')
                ->orderBy('key')
                ->get(['key', 'value']);

            $groupedServiceHighlights = [];
            foreach ($serviceHighlights as $item) {
                if (preg_match('/service_(image|title|sub_title)_(\d+)/', $item->key, $matches)) {
                    $type = $matches[1];
                    $index = (int) $matches[2];
                    $groupedServiceHighlights[$index][$type] = $item->value;
                }
            }

            ksort($groupedSocialIcons);
            ksort($groupedServiceHighlights);
            $view->with('bannerSettings', $bannerSettings);
            $view->with('websiteSettings', $websiteSettings);
            $view->with('footerSocialIcons', array_values($groupedSocialIcons));
            $view->with('footerServiceHighlights', array_values($groupedServiceHighlights));
        });

        // pass setting in all views and also if it is set is_visible true then only pass the setting
        view()->composer('*', function ($view) {
            $websiteSettings = Setting::query()
                ->select('settings.key', 'settings.value')
                ->where('settings.group', 'website')
                ->join('visibility_settings', 'visibility_settings.key', '=', 'settings.key')
                ->where('visibility_settings.is_visible', true)
                ->pluck('value', 'key')
                ->toArray();

            $view->with('websiteSettings', $websiteSettings);
        });
    }
}
