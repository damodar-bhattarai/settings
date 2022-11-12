
# Settings

Store general settings like website name, logo url, contacts in the database easily.
Everything is cached, so no extra query is done.
You can also get fresh values from the database directly if you need.




## Installation

Install the package via composer

```bash
  composer require stillalive/settings
```

Publish the migrations using the following command
```bash
php artisan vendor:publish --provider="StillAlive\Settings\SettingServiceProvider" --tag="migrations"
```
I have also added seeder for some general settings a website needs.
Seed the database using command:
```code
php artisan db:seed --class=SettingsSeeder
```
## Usage/Examples

To store settings on database
```javascript
set_settings('key','value');    
```

You can also set multiple settings at once

```code
set_settings([
        'key1'=>'value1',
        'key2'=>'value2',
        'key3'=>'value3'
    ]);
```

You can retrive the settings from cache

```code
settings('key');
```

You can provide default value to key if that key doesn't exists
```code
settings('key','default');
```

Want the settings direcly from database? You can do it,
```code
settings('key','default',true);
```

Lets see some examples:

set "site_name" as "StillAlive"

```code
set_settings('site_name','StillAlive');
```

get "site_name" value

```code
settings('site_name'); //outputs StillAlive
```

set multiple settings
```code
set_settings([
    'site_name'=>'StillAlive',
    'email'=>'info@bdamodar.com.np'
    'footer_text'=>'Copyright &copy;',
]);
```

You can use the settings on blade as
```c
{{ settings('site_name') }}
{{ settings('site_name','default value' )}}

```
Or, if you have html stored on settings

```c
{!! settings('footer_text') !!}
{!! settings('footer_text',Copyright Date('Y')) !!}
```


Finally If you have changed something directly on database, Don't forget to clear the cache.

```c
php artisan cache:clear 
```

## License

[MIT](https://choosealicense.com/licenses/mit/)


## Feedback

If you have any feedback, please reach out at info@bdamodar.com.np or submit a pull request here.


## Authors

- [@damodar-bhattarai](https://www.github.com/damodar-bhattarai)


## Badges


[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)

