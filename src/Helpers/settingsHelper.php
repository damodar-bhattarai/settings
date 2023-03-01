<?php

if (! function_exists('settings')) {
    function settings($key = null, $default = null, $fetch = false)
    {
        $settings = app()->make('\DamodarBhattarai\Settings\Models\Setting');

        if (empty($key)) {
            return $settings;
        }

        return $settings->get($key, $default, $fetch);
    }
}

if (! function_exists('short_text')) {
    function short_text($text, $length = 30, $read_more = false, $link = false, $style = '')
    {
        if ($read_more && $link) {
            $moreTag = '...<a '.$style.' href="'.$link.'">Read More</a>';
        } else {
            $moreTag = '...';
        }

        return Illuminate\Support\Str::limit(strip_tags(html_entity_decode($text)), $length, $moreTag);
    }
}
