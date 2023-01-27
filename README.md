
# Settings

Store general settings like website name, logo url, contacts in the database easily.
Everything is cached, so no extra query is done.
You can also get fresh values from the database directly if you need.




## Installation

Install the package via composer

```bash
composer require damodar-bhattarai/settings
```

Publish the migrations using the following command
```bash
php artisan vendor:publish --provider="DamodarBhattarai\Settings\SettingsServiceProvider"
```
Migrate the database
```bash
php artisan migrate
```
I have also added seeder for some general settings a website needs.
Seed the database using command:
```code
php artisan db:seed --class=SettingsSeeder
```
## Usage/Examples

To store settings on database
```code
settings()->set('key','value'); 
```

You can also set multiple settings at once

```code
settings()->set([
        'key1'=>'value1',
        'key2'=>'value2',
        'key3'=>'value3'
    ]);
```

You can retrieve the settings from cache using any command below

```code
settings('key');

settings()->get('key');
```

You can provide default value to key if that key doesn't exist
```code
settings('key','default');  //returns default
settings()->get('key','default');  //returns default

```

Want the settings directly from database? You can do it,
```code
settings('key','default',true);
settings()->get('key','default',true);
```

Getting all the settings stored on database
```code
settings()->getAll();
```

Lets see some examples:

set "site_name" as "StillAlive"

```code
settings()->set('site_name','StillAlive');
```

get "site_name" value

```code
settings('site_name'); //outputs StillAlive
```

set multiple settings
```code
settings()->set([
    'site_name'=>'StillAlive',
    'email'=>'info@bdamodar.com.np'
    'footer_text'=>'Copyright &copy;',
]);
```

You can use the settings on blade as
```code
{{ settings('site_name') }}
{{ settings('site_name','default value' )}}

```
Or, if you have html stored on settings

```code
{!! settings('footer_text') !!}
{!! settings('footer_text',Copyright Date('Y')) !!}
```


## New on v1.0.1
- added short_text() helper
short_text eliminates all the html entities including <br> so you get clean text from the html provided.

short_text($text, $length = 30, $read_more = false, $link = false, $style = '')
where,
$text is html (like from rich text editors)
$length is character limit
$read_more is boolean which helps to show or hide read more link
$link is the link to the above read_more link
$style can be used to add styles and classes like ($style='style="color:blue;" class="font-weight-bold"';)

##example
```code 
{{short_text($post->description,100,true,route('post.show',$post->id),'class="text-red-500"')}}
```

Finally, If you have changed something directly on database, Don't forget to clear the cache.

```code
php artisan cache:clear 
```

## License

[MIT](https://choosealicense.com/licenses/mit/)


## Feedback

If you have any feedback, please reach out at damodar.bhattarai.1999@gmail.com or submit a pull request here.


## Authors

- [@damodar-bhattarai](https://www.github.com/damodar-bhattarai)


## Badges


[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)

