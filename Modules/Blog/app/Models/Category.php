<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Models\Post;
use Modules\SEO\Traits\HasSeoMeta;
use Modules\ActivityLog\Traits\LogsActivity;

class Category extends Model
{
    use LogsActivity, HasSeoMeta, HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'parent_id',
        'description',
        'status',
        'icon',
        'order',
        'is_featured'
    ];

    /**
     * Relationship: Category has many Posts
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_categories');
    }

    /**
     * Relationship: Parent Category
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relationship: Direct child categories
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Relationship: Recursive child categories (load all nested levels)
     */
    public function childrenRecursive()
    {
        return $this->children()->with(['childrenRecursive', 'posts']);
    }

    /**
     * Scope: Only top-level published categories (for convenience)
     */
    public function scopeTopPublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNull('parent_id')
                     ->orderBy('order', 'asc');
    }
}
