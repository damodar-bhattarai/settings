<?php

namespace StillAlive\Settings;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use StillAlive\Settings\Models\Setting;

class SettingsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if(!Cache::has('stillalive-settings')){
            Cache::rememberForever('stillalive-settings', function () {
                return Setting::all();
            });
        }

        $this->publishMigrations();
    }

    protected function publishMigrations()
    {
        if ($this->app->runningInConsole()) {
            if (!class_exists('CreateAppSettingsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_settings_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_settings_table.php'),
                    __DIR__ . '/../database/seeders/SettingsSeeder.php.stub' => database_path('migrations/seeders/SettingsSeeder.php'),
                ], 'migrations');
            }
        }
    }

    public function register()
    {
        // load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}