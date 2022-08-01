<?php

namespace StillAlive\Settings;

use Illuminate\Support\Facades\Cache;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use StillAlive\Settings\Commands\SettingsCommand;

class SettingsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('settings')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_settings_table')
            ->hasCommand(SettingsCommand::class)
            ->sharesDataWithAllViews(Cache::rememberForever('settings', function () {
                return Settings::all();
            }), 'settings');
    }

    public function register()
    {
        $this->app->bind('setting', function ($app) {
            return new Settings();
        });
    }
}
