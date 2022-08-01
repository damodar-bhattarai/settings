<?php

namespace StillAlive\Settings\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \StillAlive\Settings\Settings
 */
class Settings extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \StillAlive\Settings\Settings::class;
    }
}
