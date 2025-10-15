<?php

use Illuminate\Support\Str;
use Modules\Language\Models\Language;


if (!function_exists('breadcrumb')) {
    function breadcrumb(): \App\Support\Breadcrumb
    {
        return app('breadcrumb');
    }
}

if (! function_exists('humanize_string')) {
    function humanize_string(string $value): string
    {
        return ucwords(str_replace('.', ' ', $value));
    }
}


if (!function_exists('formatFileSize')) {
    function formatFileSize($bytes)
    {
        if ($bytes == 0) return '0 Bytes';
        $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), 2) . ' ' . $sizes[$i];
    }
}


if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return \Modules\Setting\Models\Setting::where('key', $key)->value('value') ?? $default;
    }
}

if (!function_exists('is_module_enabled')) {
    function is_module_enabled(string $module): bool
    {
        $setting = \Modules\Setting\Models\Setting::where('key', $module)->first();

        return $setting && (int) $setting->value === 1;
    }
}

if (! function_exists('title_case')) {
    function title_case($string): string
    {
        return Str::title(str_replace('_', ' ', $string));
    }
}
if (! function_exists('setting_image_url')) {
    function setting_image_url($key)
    {
        $file = setting($key);
        if (!$file) {
            return null;
        }
        $abs = public_path('settings/images/' . $file);
        if (!file_exists($abs)) {
            return null;
        }
        return asset('settings/images/' . $file) . '?v=' . filemtime($abs);
    }
}
if (! function_exists('imageOrPlaceholder')) {
    function imageOrPlaceholder($path, $default)
    {
        return !empty($path) && file_exists(public_path($path))
            ? asset($path)
            : asset($default);
    }
}
