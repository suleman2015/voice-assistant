<?php

use Illuminate\Support\Str;
use Modules\Language\App\Models\Language;


if (! function_exists('modify_trans_data')) {
    function modify_trans_data($data, $associative = true)
    {
        $data = json_decode($data, $associative);

        $validLanguages = Language::languageGet()->keys();

        return $associative
            ? collect($data)->only($validLanguages)->all()
            : (object) collect($data)->only($validLanguages)->all();
    }
}

if (! function_exists('title_case')) {

    function title_case($string): string
    {
        return Str::title(str_replace('_', ' ', $string));
    }
}
