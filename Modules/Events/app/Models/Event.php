<?php

namespace Modules\Events\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ActivityLog\Traits\LogsActivity;

class Event extends Model
{
    use LogsActivity, HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'event_date',
        'description',
        'link',
        'image_url',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
        'status'     => 'string',
    ];

    /**
     * Relationships
     */
    public function images()
    {
        return $this->hasMany(EventImage::class);
    }

    public function eventDates()
    {
        return $this->hasMany(EventDate::class);
    }
}
