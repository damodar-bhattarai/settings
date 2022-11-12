<?php

if (!function_exists('settings')) {

    function settings($key = null, $default = null, $fetch = false)
    {
        $settings = app()->make('\DamodarBhattarai\Settings\Models\Setting');

        if (empty($key)) return $settings;
        return $settings->get($key, $default, $fetch);
    }
}

