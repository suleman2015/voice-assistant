<?php

namespace Modules\Newsletter\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $fillable = [
        'email', 'name', 'status',
    ];
}