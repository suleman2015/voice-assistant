<?php

namespace Modules\Menu\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\ActivityLog\Traits\LogsActivity;


class Menu extends Model
{
    use LogsActivity;

    protected $table = 'menus';

    protected $fillable = ['name','location','is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)
            ->whereNull('parent_id')
            ->orderBy('order');
    }
}