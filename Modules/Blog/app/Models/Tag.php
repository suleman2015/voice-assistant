<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Models\Post;
use Modules\ActivityLog\Traits\LogsActivity;

class Tag extends Model
{
    use LogsActivity, HasFactory;

    protected $fillable = ['name', 'description', 'status'];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }
}
