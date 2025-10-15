<?php

namespace Modules\Menu\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MenuItem extends Model
{
    protected $table = 'menu_items';

    protected $fillable = [
        'menu_id', 'parent_id', 'title', 'type',
        'url', 'reference_type', 'reference_id',
        'route_name', 'route_params',
        'icon_class', 'css_class', 'is_new_tab', 'locale', 'order',
    ];

    protected $casts = [
        'route_params' => 'array',
        'is_new_tab'   => 'boolean',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    /**
     * Polymorphic relation to get the referenced model
     * Example: $menuItem->reference
     */
    public function reference(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'reference_type', 'reference_id');
    }
}
