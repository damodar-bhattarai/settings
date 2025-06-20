<?php

namespace DamodarBhattarai\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $guarded = ['id'];
    protected $table = 'settings';

    protected $casts = [
        'value' => 'array',
    ];

    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }

            return true;
        }

        // Ensure value is properly formatted for JSON storage
        $storedValue = is_array($value) || is_object($value) ? json_encode($value) : $value;

        $settings = $this->getModelName()->updateOrCreate(
            ['key' => $key],
            ['value' => $storedValue]
        );
        $this->forgetCache();

        return $settings;
    }

    public function getModelName()
    {
        return app('\DamodarBhattarai\Settings\Models\Setting');
    }

    public function forgetCache()
    {
        Cache::forget($this->getCacheName());
    }

    public function getCacheName(): string
    {
        return 'damodarbhattarai-settings';
    }

    public function get($key, $default = null, $fetch = false)
    {
        if (is_array($key)) {
            return $this->getMany($key, $fetch);
        }

        $value = $this->getAll($fetch)->get($key, $default);

        // Handle backward compatibility for text values
        if (is_string($value) && $this->isJson($value)) {
            return json_decode($value, true);
        }

        return $value;
    }

    public function getMany($keys, $fetch)
    {
        $results = $this->getAll($fetch)->only($keys);

        // Process each value for backward compatibility
        return $results->map(function ($value) {
            if (is_string($value) && $this->isJson($value)) {
                return json_decode($value, true);
            }
            return $value;
        })->all();
    }

    public function getAll($fetch = false)
    {
        if ($fetch) {
            $settings = $this->getModelName()->pluck('value', 'key');
        } else {
            $settings = Cache::rememberForever($this->getCacheName(), function () {
                return $this->getModelName()->pluck('value', 'key');
            });
        }

        // Process values to ensure compatibility with text and JSON
        return $settings->map(function ($value) {
            if (is_string($value) && $this->isJson($value)) {
                return json_decode($value, true);
            }
            return $value;
        });
    }

    public function remove($key)
    {
        if (is_array($key)) {
            foreach ($key as $k) {
                $this->remove($k);
            }

            return true;
        }
        $this->getModelName()->where('key', $key)->delete();
        $this->forgetCache();
    }

    public function has($key)
    {
        return $this->getAll()->has($key);
    }

    /**
     * Check if a string is valid JSON
     *
     * @param string $string
     * @return bool
     */
    protected function isJson($string): bool
    {
        if (!is_string($string)) {
            return false;
        }
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
