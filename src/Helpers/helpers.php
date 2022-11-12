<?php

use Illuminate\Support\Facades\Cache;
use StillAlive\Settings\Models\Setting;

if (!function_exists('settings')) {
    function settings($key, $default = null, $fetch = false)
    {
        if ($fetch) {
            $setting = Setting::where('key', $key)->first();
        } else {
            $settings = Cache::rememberForever('stillalive-settings', function () {
                return Setting::all();
            });
            $setting = $settings->where('key', $key)->first();
        }

        return $setting ?? $default;
    }
}
if (!function_exists('set_settings')) {

    function set_settings($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                set_settings($k, $v);
            }
            return true;
        }

        $setting = Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('stillalive-settings');
        return $setting;
    }
}

?>