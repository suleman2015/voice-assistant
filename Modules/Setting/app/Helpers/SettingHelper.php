<?php

namespace Modules\Setting\Helpers;

use Modules\Setting\Models\Setting;

class SettingHelper
{
    public static function get($key, $default = null)
    {
        return Setting::where('key', $key)->value('value') ?? $default;
    }

    public static function set($key, $value)
    {
        return Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function all()
    {
        return Setting::pluck('value', 'key')->toArray();
    }
   
}
