<?php

namespace Modules\UserRoles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Modules\ActivityLog\Traits\LogsActivity;

class Permission extends SpatiePermission
{
    use LogsActivity, HasFactory;

    protected $table = 'permissions';

    protected $fillable = ['name', 'category', 'guard_name'];
}
