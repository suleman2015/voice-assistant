<?php

namespace Modules\UrlRedirector\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UrlRedirector extends Model
{
    use HasFactory;

   protected $table = 'url_redirects';

        protected $fillable = [
        'original_url',
        'target_url',
        'visits',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];
}
