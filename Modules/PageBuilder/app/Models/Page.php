<?php

namespace Modules\PageBuilder\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\SEO\Traits\HasSeoMeta;

class Page extends Model
{
    use HasSeoMeta;
    
    use HasFactory;

    protected $fillable = [
        'is_breadcrumb',
        'title',
        'slug',
        'content',
        'type',
        'is_active',
    ];

    protected $guarded = ['id'];

}
