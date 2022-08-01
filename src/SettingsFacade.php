<?php

namespace Stillalive\Settings;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Stillalive\Settings\Skeleton\SkeletonClass
 */
class SettingsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'settings';
    }
}
