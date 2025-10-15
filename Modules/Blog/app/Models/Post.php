<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Tag;
use Modules\SEO\Traits\HasSeoMeta;
use Modules\Users\Models\User;
use Modules\ActivityLog\Traits\LogsActivity;

class Post extends Model
{
    use LogsActivity, HasSeoMeta, HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'content',
        'status',
        'author_id',
        'author_name',
        'is_featured',
        'is_trending_onc_update',
        'type',
        'image',
        'dr_image',
        'dr_name',
        'apple_link',
        'spotify_link',
        'yt_link',
        'key_points',
    ];

    // Cast key_points to array
    protected $casts = [
        'is_featured' => 'boolean',
        'is_trending_onc_update' => 'boolean',
        'key_points' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_categories');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }
    public function keywords()
    {
        return $this->belongsToMany(Tag::class, 'post_keywords');
    }
    public function relatedPosts($limit = 2)
    {
        // collect category and tag IDs of current post
        $categoryIds = $this->categories()->pluck('categories.id')->toArray();
        $tagIds = $this->tags()->pluck('tags.id')->toArray();

        // base query for related posts
        $query = self::where('status', 'published')
            ->where('id', '!=', $this->id)
            ->where(function ($q) use ($categoryIds, $tagIds) {
                if (!empty($categoryIds)) {
                    $q->whereHas('categories', function ($q2) use ($categoryIds) {
                        $q2->whereIn('categories.id', $categoryIds);
                    });
                }
                if (!empty($tagIds)) {
                    $q->orWhereHas('tags', function ($q3) use ($tagIds) {
                        $q3->whereIn('tags.id', $tagIds);
                    });
                }
            })
            ->inRandomOrder()
            ->limit($limit);

        $related = $query->get();

        // fallback: if fewer than requested, fill with latest posts
        if ($related->count() < $limit) {
            $missing = $limit - $related->count();
            $latest = self::where('status', 'published')
                ->where('id', '!=', $this->id)
                ->latest()
                ->limit($missing)
                ->get();

            $related = $related->merge($latest);
        }

        return $related;
    }


    // public function getRouteKeyName(): string
    // {
    //     return 'slug';
    // }
}
