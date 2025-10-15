<?php

namespace Modules\Events\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'date',
        'link',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Relationship back to Event
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
