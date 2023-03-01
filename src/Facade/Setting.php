<?php

namespace DamodarBhattarai\Settings\Facade;

use Illuminate\Support\Facades\Facade;

class Setting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'DamodarBhattarai\Settings\Models\Setting';
    }
}
