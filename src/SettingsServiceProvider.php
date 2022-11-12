<?php

namespace DamodarBhattarai\Settings;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use DamodarBhattarai\Settings\Facades\Setting;


class SettingsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishMigrations();
    }

    protected function publishMigrations()
    {
        if ($this->app->runningInConsole()) {
            if (!class_exists('CreateSettingsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_settings_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_settings_table.php'),
                    __DIR__ . '/../database/seeders/SettingsSeeder.php.stub' => database_path('seeders/SettingsSeeder.php'),
                ], 'migrations');
            }
        }
    }

    public function register()
    {
        // Register a class in the service container
        $this->app->bind('setting', function ($app) {
            return new Setting();
        });

        // load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

}
