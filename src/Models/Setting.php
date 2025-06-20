<?php

namespace DamodarBhattarai\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $guarded = ['id'];
    protected $table = 'settings';

    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }

            return true;
        }

        // Encode all values as JSON
        $storedValue = json_encode($value);

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

        // Decode JSON value, handling both new and existing data
        return $this->decodeValue($value, $default);
    }

    public function getMany($keys, $fetch)
    {
        $results = $this->getAll($fetch)->only($keys);

        // Decode each JSON value
        return $results->map(function ($value) {
            return $this->decodeValue($value);
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

        // Decode all JSON values
        return $settings->map(function ($value) {
            return $this->decodeValue($value);
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
     * Decode JSON value, handling both JSON and plain text for backward compatibility
     *
     * @param mixed $value
     * @param mixed $default
     * @return mixed
     */
    protected function decodeValue($value, $default = null)
    {
        if (is_null($value)) {
            return $default;
        }

        // If the value is not valid JSON, return it as is (for backward compatibility)
        if (is_string($value) && !$this->isJson($value)) {
            return $value;
        }

        // Decode JSON value
        $decoded = json_decode($value, true);

        // Return decoded value or default if decoding fails
        return (json_last_error() === JSON_ERROR_NONE) ? $decoded : $default;
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
