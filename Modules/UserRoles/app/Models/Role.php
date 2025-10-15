<?php

namespace Modules\UserRoles\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ActivityLog\Traits\LogsActivity;


class Role extends SpatieRole
{
    use LogsActivity, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'guard_name',
    ];

    // Optionally, you can define a custom factory if needed
    // protected static function newFactory(): RoleFactory
    // {
    //     return RoleFactory::new();
    // }
}
