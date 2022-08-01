## Installation
You can install package via composer
    composer require stillalive/settings

Publish the migrations using
    php artisan vendor:publish --tag="settings-migrations"

Run the migrations using
    php artisan migrate


## Usage

set value to settings
settings()->set('key','value')

get value from settings
 settings()->get('key')

get value from settings with default result if key doesn't exists
settings()->get('key','default value')

get un-cached value
settings()->get('key','default',true)

