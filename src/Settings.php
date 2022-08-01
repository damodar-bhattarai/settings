<?php

namespace StillAlive\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Settings extends Model
{

    protected $cachePrefix = 'stillalive-settings';

    public function set($key, $value=null)
    {
        if(is_array($key)){
            foreach($key as $row=>$value){
                $this->set($row, $value);
            }
            return true;
        }

        Settings::firstOrCreate(['key' => $key],['value' => $value]);

        return $this->cachedSettings($key,true);
    }

    public function get($key, $default=null, $forget=false){
        return $this->cachedSettings($key,$forget,$default);
    }


    public function cachedSettings($key,$forget=false,$default=null){

        if($forget){
            Cache::forget($this->cachePrefix.$key);
        }

       return Cache::rememberForever($this->cachePrefix.$key, function () use($key,$default) {
            $setting= Settings::select('key','value')->where('key',$key)->first();
            if($setting){
                return $setting->value;
            }else{
                return $default;
            }
        });
    }

    public function setAllSettings(){
        $settings= Settings::select('key','value')->get();
        foreach($settings as $setting){
            $this->cachedSettings($setting->key,true,$setting->value);
        }
    }

}
