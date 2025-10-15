<?php

namespace Modules\Recaptcha\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecaptchaSetting extends Model
{
    protected $table = 'recaptcha_settings';

    use HasFactory;

    protected $fillable = ['enabled', 'site_key', 'secret_key'];
}
