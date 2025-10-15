<?php

namespace Modules\Recaptcha\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecaptchaForm extends Model
{
    use HasFactory;

    protected $table = 'recaptcha_forms';

    protected $fillable = ['form_name', 'enabled'];

    public static function isEnabled($formName): bool
    {
        return self::where('form_name', $formName)->where('enabled', true)->exists();
    }
}
