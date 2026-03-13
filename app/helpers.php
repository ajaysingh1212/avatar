<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {

    function setting($key = null)
    {
        $settings = Cache::rememberForever('app_settings', function () {
            return Setting::first();
        });

        if (!$settings) {
            return null;
        }

        if ($key) {
            return $settings->$key ?? null;
        }

        return $settings;
    }

}
