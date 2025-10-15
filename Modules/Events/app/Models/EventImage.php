<?php

namespace Modules\Events\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'image_url',
    ];

    /**
     * Relationship back to Event
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
