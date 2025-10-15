<?php

namespace Modules\Conversations\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Users\Models\User;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'user_id',
        'role',
        'content',
        'content_delta',
        'input_audio_path',
        'audio_path',
        'lang',
        'timings',
        'status',
        'error_message'
    ];
    protected $casts = ['timings' => 'array'];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
